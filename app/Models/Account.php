<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];
    /**
     * Return the user of this account
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Return the transactions in this account
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'DESC');
    }
    
}
