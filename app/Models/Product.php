<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
      'company_id',
      'product_name',
      'stock',
      'comment',
  ];

    protected $guarded = [
      'price'
    ];

    public function companies() {
      //return $this->belongsTo('App\Models\Company', 'id','company_id' );
      return $this->belongsTo(Company::class);
    }
     
    public function sales () {
      return $this->hasMany(Sale::class);
    }
}
