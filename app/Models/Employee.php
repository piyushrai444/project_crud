<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = ['id', 'first_name', 'last_name', 'company_id', 'email', 'phone', 'status'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
