<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{

    public function index()
    {
        return view('student.index')->with('students',Student::where('active', 1)->get());
    }
    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        Student::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Aluno cadastrado com sucesso!'
        ]);
    }

    public function edit($id)
    {   
        return view('student.edit')->with('student', Student::findOrFail($id));
    }

    public function update(Request $request)
    {
        Student::where('id', $request->id)->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Aluno atualizado com sucesso!'
        ]);
    }


    public function destroy(Request $request)
    {
        Student::where('id', $request->id)->update(['active' => 0]);

        return $this->allStudents();
    }

    public function report($id){

        return response()->json(Student::with('adress','registration.classroom')->where('id',$id)->get());
    }

    protected function allStudents()
    {
        return response()->json(Student::where('active', 1)->get());
    }
}
