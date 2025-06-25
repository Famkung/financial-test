<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'prefix',
        'first_name',
        'last_name',
        'birthdate',
        'profile_image',
        'updated_at'
    ];

    public $timestamps = true;
}
