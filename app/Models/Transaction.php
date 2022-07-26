<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Return the account this transaction belongs to
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    /**
     * Return the category this transaction  belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Return the sub category this transaction belong to
     */
    public function subCategory()
    {
        $this->hasOneThrough(Category::class, SubCategory::class);
    }
}
