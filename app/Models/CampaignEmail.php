<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
      'subject',
      'body',
      'status',
      'user_id',
  ];
}
