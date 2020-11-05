<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Student;
use App\Models\Classroom;

class RegistrationController extends Controller
{
    //
    public function index()
    {

        return view('registration.index')->with('registration', Registration::with('student', 'classroom')->get());
    }

    public function create()
    {
        return view('registration.create')
            ->with('classrooms', Classroom::where('active', 1)->get(['name', 'id']))
            ->with('students', Student::where('active', 1)->get(['name', 'id']));
    }

    public function store(Request $request)
    {

        $exists = Registration::where('student_id', $request->student_id)->count();

        if ($exists == 0) {

            Registration::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Matícula cadastrada com sucesso!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Aluno já matriculado!'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        Registration::where('id', $request->id)->delete();

        return $this->allRegistrations();
    }

    protected function allRegistrations()
    {
        return response()->json(Registration::with('student', 'classroom')->get());
    }
}
