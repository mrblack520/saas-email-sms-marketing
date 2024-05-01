<?php

namespace wave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeConfiguration extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'secret'];
}
