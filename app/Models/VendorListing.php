<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorListing extends Model
{
    protected $table = 'vendor_listings';

    protected $fillable = [
        'product_id',
        'shop_id',
        'sku',
        'price',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'shop_id'    => 'integer',
        'price'      => 'decimal:2',
        'stock'      => 'integer',
        'is_active'  => 'boolean',
    ];

    // İlişkiler
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function shop()
    {
        return $this->belongsTo(\App\Models\Shop::class);
    }

    // Kullanışlı scope'lar
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeForShop($q, int $shopId)
    {
        return $q->where('shop_id', $shopId);
    }
}
