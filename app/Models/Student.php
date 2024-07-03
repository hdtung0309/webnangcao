<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'full_name',
        'gender',
        'birth_date',
        'hometown',
        'email',
        'phone_number',
        'username',
        'password',
        'avatar',
        'note',
        'class_id',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
