<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

use function str_replace;

class RoleKeyService
{
    public const TYPE_CREATE = 'CREATE';
    public const TYPE_READ = 'READ';
    public const TYPE_UPDATE = 'UPDATE';
    public const TYPE_DELETE = 'DELETE';

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
     * @param string $role
     * @access public
     * @return string
     */
    public function getCreateKey(string $role): string
    {
        return $role . '_' . self::TYPE_CREATE;
    }

    /**
     * @param string $role
     * @access public
     * @return string
     */
    public function getReadKey(string $role): string
    {
        return $role . '_' . self::TYPE_READ;
    }

    /**
     * @param string $role
     * @access public
     * @return string
     */
    public function getUpdateKey(string $role): string
    {
        return $role . '_' . self::TYPE_UPDATE;
    }

    /**
     * @param string $role
     * @access public
     * @return string
     */
    public function getDeleteKey(string $role): string
    {
        return $role . '_' . self::TYPE_DELETE;
    }

    /**
     * @access public
     */
    public function getTypes(): array
    {
        return [
            self::TYPE_CREATE,
            self::TYPE_READ,
            self::TYPE_UPDATE,
            self::TYPE_DELETE,
        ];
    }

    public function convertToBasicDescription(string $generatedRole): string
    {
        $description = str_replace('_', ' ', strtolower($generatedRole));
        return ucwords($description);
    }
}
