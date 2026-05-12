<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS_CREATED = 'created';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_IN_TRANSIT = 'in_transit';
    public const STATUS_DELIVERED = 'delivered';

    public const STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_ACCEPTED,
        self::STATUS_IN_TRANSIT,
        self::STATUS_DELIVERED,
    ];

    private const PRICE_PER_KG = 120;

    protected $fillable = [
        'sender_name',
        'recipient_name',
        'origin_city',
        'destination_city',
        'weight',
        'price',
        'status',
        'comment',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public static function calculatePrice(float $weight): float
    {
        return round($weight * self::PRICE_PER_KG, 2);
    }
}
