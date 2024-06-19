<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['c_name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'associations', 'c_id', 'p_id');
    }
}
