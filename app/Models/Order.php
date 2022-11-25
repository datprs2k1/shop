<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'status',
        'name',
        'address',
        'ward',
        'district',
        'city',
        'phone',
        'method'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id')->withPivot('quantity');
    }
}
