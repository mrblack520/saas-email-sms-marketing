<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_status',
        'invoice_number',
        'receipt_number',
        'date_paid',
        'payment_method',
        'billing_email',
        'amount_paid',
    ];
}
