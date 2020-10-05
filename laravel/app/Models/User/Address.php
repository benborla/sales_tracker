<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Relations\BelongsToUser;

/**
 * @property int $id
 * @property int $user_id
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country
 * @property array $type
 */
class Address extends Model
{
    use BelongsToUser;

    public const TYPE_BILLING = 'BILLING';
    public const TYPE_SHIPPING = 'SHIPPING';

    public $table = 'address';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'street',
        'city',
        'state',
        'zipcode',
        'country',
        'type'
    ];

    public static function getTypes(): array
    {
        return [
            self::TYPE_BILLING,
            self::TYPE_SHIPPING
        ];
    }
}
