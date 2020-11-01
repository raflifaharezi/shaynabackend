<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Product extends Model
{
    use softDeletes;
    protected $fillable = ['name', 'type', 'price', 'slug','quantity','description'];
    protected $hidden = [];

    public function galleries()
    {       
        return $this->hasMany(ProductGallery::class, 'products_id');
    }
    
}
