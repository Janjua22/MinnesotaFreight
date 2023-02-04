<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    /**
    * @var string
    */
    protected $table = 'contact_us';

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    
    /**
    * @var array
    */
    protected $fillable = [
        'name',
        'email' ,
        'subject' ,
        'message',
        'read',
    ];
}