<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class ProductGallery extends Model
{
    use softDeletes;
    protected $fillable = ['products_id','photo', 'is_default'];
    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
     // jangan lupa membuat php artisan storage:link 
    public function getphotoAttribute ($value)
    {
        return url('storage/'.$value);
    }
}
