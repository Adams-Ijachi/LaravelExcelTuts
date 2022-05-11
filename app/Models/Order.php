<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',   
        'city', 
        'product_id',   
      
        'quantity', 
        'price',    
        'total',    
        'order_date',   
    ];

    protected $casts = [
        'order_date' => 'date',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    




}
