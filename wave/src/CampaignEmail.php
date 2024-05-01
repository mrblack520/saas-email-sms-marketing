<?php

namespace wave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'to', 'subject', 'body', 'status', 'user_id'
  ];
}
