<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wave\Users;
use Wave\Campaign;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable=[
        'UsersID',
        'subscriptionID',

    ];


    public function users(){
       return  $this->belongsTo(Users::class, 'id');
    }


    public function Campaign(){
        return  $this->belongsTo(Campaign::class, 'id');
     }
}
