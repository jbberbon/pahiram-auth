<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Uuids;

    protected $primaryKey = 'id';
    public $incrementing = false; // Disable auto-incrementing for UUID
    protected $keyType = 'string'; // Set the key type to string for UUID
    protected $fillable = [
        'course_code',
        'course',
        'course_acronym'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
