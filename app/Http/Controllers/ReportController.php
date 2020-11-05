<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Registration;

class ReportController extends Controller
{
    //
    public function reportStudent($id)
    {

        return response()->json(Student::with('adress', 'registration.classroom')->where('id', $id)->get());
    }

    public function reportClassroom($id)
    {

        return response()->json(Registration::with('classroom', 'student')->where('classroom_id', $id)->get());
    }
}
