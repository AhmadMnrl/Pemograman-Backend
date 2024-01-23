<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = [
        'nama',
        'nim',
        'email',
        'major',
        'city',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id';
    public function getStudents(){
    $students = DB::select("select * from students");
    return $students;
    }
}
