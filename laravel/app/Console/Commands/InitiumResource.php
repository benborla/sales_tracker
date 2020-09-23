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

        echo 'Creating your controller' . \PHP_EOL;
        $this->call("make:controller $namespace/{$resourceName}Controller --api");


        echo "$resourceName on $namespace";


        return 0;
    }
}
