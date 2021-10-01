<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'new_orders';

    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
        'status',
        'payment_id',
        'payment_url',
        'payed_at'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
