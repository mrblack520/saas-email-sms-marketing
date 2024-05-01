<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'lname',
        'email',
        'number',
        'description',
        'status',
        'UsersID'
    ];


    public function users(){
        return  $this->belongsTo(Users::class, 'id');
     }
}
