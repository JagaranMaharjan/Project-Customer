<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //table name
    protected $table='customerInfo';
    //student table field name
    protected  $fillable = ['customerName', 'address', 'organization', 'email', 'mobile', 'image'];
}
