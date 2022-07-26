<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    /**
     * Return the category this sub category belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
