<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name','slug','settings'];
    protected $casts = ['settings' => 'array'];

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'created_by_vendor_id');
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class); // users.vendor_id FK
    }
}
