<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
      'company_id',
      'product_name',
      'image',
      'price',
      'stock',
      'comment',
  ];
    
    protected $guarded = [
    ];

    public function company() {
      return $this->belongsTo('App\Models\Company');
    }

    public function sales () {
      return $this->hasMany(Sale::class);
    }

    
}
