<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'initial_payment_percentage',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'initial_payment_percentage' => 'integer',
        'is_active' => 'boolean',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function getInitialPaymentAmountAttribute()
    {
        return $this->price * ($this->initial_payment_percentage / 100);
    }

    public function getFinalPaymentAmountAttribute()
    {
        return $this->price - $this->initial_payment_amount;
    }
}
