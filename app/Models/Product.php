<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['p_name'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'associations', 'p_id', 'c_id');
    }
}
