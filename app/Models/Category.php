<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Return all transactions in this category
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'DESC');
    }
    /**
     * Return all sub categories in the category
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    
}
