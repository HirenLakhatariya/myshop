<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us'; // Table name
    protected $fillable = ['name', 'email', 'contact_number', 'message'];
}
