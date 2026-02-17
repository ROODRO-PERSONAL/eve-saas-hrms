<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'position', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
