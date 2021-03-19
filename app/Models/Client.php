<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name',
        'GreetingInitial',
        'Icon',
        'Logo',
        'Header',
        'WebSite',
        'CreateDate',
        'ClientStatus',
        'F9ClientID',
        'CallCLosing',
        'CustomerInfoOpening',
        'CallBackScript',
        'SourceScript',
        'TopPrograms'
    ];
}
