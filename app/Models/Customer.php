<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'company', 'country', 'status', 'total_spent'];

    public function orders() { return $this->hasMany(Order::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
}
