<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    
    protected $fillable = [
      'company_name',
      'street_address',
  ];
    protected $guarded = array('id');
    
    public function products() {
      return $this->hasMany('App\Models\Product');
    }

    public function getCompany() {
      $getCompanyName = Company::pluck('company_name', 'id');
      return $getCompanyName;
    }
  }