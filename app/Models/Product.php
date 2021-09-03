<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Kyslik\ColumnSortable\Sortable; //ソート機能

class Product extends Model
{
    use HasFactory;
    use Sortable;

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

    public $sortable = ['id', 'product_name', 'price', 'stock', 'company_id', ];

    
}
