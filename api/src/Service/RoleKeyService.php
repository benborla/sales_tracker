<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

use function str_replace;

class RoleKeyService
{
    public const TYPE_READ = 'READ';
    public const TYPE_WRITE = 'WRITE';

    /**
     * @var \Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter
     * @access protected
     */
    protected $camelCaseConverter;

    public function __construct(CamelCaseToSnakeCaseNameConverter $camelCaseConverter)
    {
        $this->camelCaseConverter = $camelCaseConverter;
    }

    /**
     * getKey
     *
     * @param mixed $channel
     * @param mixed $entity
     * @param string $type
     * @access public
     * @return string
     */
    public function getKey(
        string $channel,
        string $entity
    ): string {
        $channel = $this->camelCaseConverter->normalize(strtolower($channel));
        $entity = $this->camelCaseConverter->normalize($entity);
        $key = "{$channel}_{$entity}";

        return strtoupper($key);
    }

    /**
     * getReadKey
     *
     * @param string $role
     * @access public
     * @return string
     */
    public function getReadKey(string $role): string
    {
        return $role . '_' . self::TYPE_READ;
    }

    /**
     * getWriteKey
     *
     * @param string $role
     * @access public
     * @return string
     */
    public function getWriteKey(string $role): string
    {
        return $role . '_' . self::TYPE_WRITE;
    }

    public function convertToBasicDescription(string $generatedRole): string
    {
        $description = str_replace('_', ' ', strtolower($generatedRole));
        return ucwords($description);
    }
}
