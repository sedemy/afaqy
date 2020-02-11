<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Student;
class Grade extends Model
{
    protected $table = "grades";
    protected $fillable = ['student_id','course_id','total_oral','total_work','total_exam'];
    public $timestamps= false;


}
