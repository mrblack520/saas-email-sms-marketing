<?php

namespace wave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wave\Subscriber;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_name',
        'campaign_type',
        'template',
        'status',
        'UsersID',
    ];

public function subscribers(){

    return $this->hasMany(Subscriber::class , 'id');
}

}
