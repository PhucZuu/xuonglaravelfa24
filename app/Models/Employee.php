<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'hire_date',
        'is_active',
        'address',
        'profile_picture',
        'department_id',
        'manager_id',
    ];

    public $attribute = [
        'is_active' => 0
    ];

}
