<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitiumResource extends Command
{
    private $paths = [
        // path => namespace
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initium:resource
                            {resourceName : Name of the resource}
                            {--namespace= : Where should the resouce would be under to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will create a resource for Initium';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $resourceName = \ucfirst($this->argument('resourceName'));
        $namespace = \ucfirst($this->option('namespace'));

        echo 'Creating controller and model file' . \PHP_EOL;
        // $this->call('make:controller', [
            // 'name' => "$namespace/{$resourceName}Controller",
            // '--api' => true,
            // '--model' => "$namespace/$resourceName"
        // ]);

        echo 'Creating resource file' . \PHP_EOL;
        // $this->call('make:resource', [
            // 'name' => "$namespace/{$resourceName}Resource"
        // ]);

        echo 'Creating test file' . \PHP_EOL;
        // $this->call('make:test', [
            // 'name' => "$namespace/{$resourceName}ControllerTest"
        // ]);
        //
        echo 'Generating repository' . \PHP_EOL;
        $this->generateRepository($namespace, $resourceName);

        // Update RepositoryServiceProvider
        $this->updateRepositoryProvider($namespace, $resourceName);

        return 0;
    }

    private function updateRepositoryProvider(string $namespace, string $resource)
    {
        $namespace = $namespace . "\\";
        $repositoryInterfaceClass = "App\\Repository" . $namespace . $resource . 'RepositoryInterface';
        $repositoryClass = "App\\Repository\\Eloquent" . $namespace . $resource . 'Repository';

        $register = \sprintf('$this->app->bind(\%s, \%s);', $repositoryInterfaceClass, $repositoryClass);
    }

    private function generateRepository(string $namespace, string $resourceName)
    {
        $dirName = $namespace ? $namespace . '/' : '';
        $repositoryInterfacePath = \base_path() . '/app/Http/Repository/Interface' . $dirName;
        $repositoryEloquentPath = \base_path() . '/app/Http/Repository/Eloquent/' . $dirName;
        $namespace =  $namespace ? '\\' . $namespace : '';
        $stubsPath = \base_path() . '/stubs';
        $repositoryStub = $stubsPath . '/Repository.php.stub';
        $repositoryInterfaceStub = $stubsPath . '/RepositoryInterface.php.stub';
        $repositoryServiceProvider = \base_path() . '/app/Providers/RepositoryServiceProvider.php';

        if (!\file_exists($stubsPath) &&
            !\file_exists($repositoryStub) &&
            !\file_exists($repositoryInterfaceStub)
        ) {
            return 0;
        }

        $resource = $resourceName;
        $resourceName = '\\' . $resourceName;

        $repository = \file_get_contents($repositoryStub);
        $repositoryInterface = \file_get_contents($repositoryInterfaceStub);

        $repository = str_replace([
            '{{namespace}}',
            '{{resourceName}}',
            '{{resource}}'
        ], [
            $namespace,
            $resourceName,
            $resource
        ], $repository);

        $repositoryInterface = str_replace([
            '{{namespace}}',
            '{{resourceName}}',
            '{{resource}}'
        ], [
            $namespace,
            $resourceName,
            $resource
        ], $repositoryInterface);

        $this->createFile($repositoryInterfacePath, $resource . 'RepositoryInterface.php', $repositoryInterface);
        $this->createFile($repositoryEloquentPath, $resource . 'Repository.php', $repository);
    }

    private function createFile($path, $fileName, $content)
    {
        if (!\file_exists($path)) {
            mkdir($path, 0777, true);
            $this->createFile($path, $fileName, $content);
        }

        file_put_contents($path . $fileName, $content);
    }
}
