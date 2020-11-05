<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Registration;

class ClassroomController extends Controller
{
    //
    public function index()
    {
        return view('classroom.index')->with('classrooms', Classroom::where('active', 1)->get());
    }

    public function create()
    {
        return view('classroom.create');
    }

    public function store(Request $request)
    {
        Classroom::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Turma cadastrada com sucesso!'
        ]);
    }

    public function edit($id)
    {
        return view('classroom.edit')->with('classroom', Classroom::findOrFail($id));
    }

    public function update(Request $request)
    {
        Classroom::where('id', $request->id)->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Turma atualizada com sucesso!'
        ]);
    }

    public function destroy(Request $request)
    {
        Classroom::where('id', $request->id)->update(['active' => 0]);

        return $this->allClassRooms();
    }

    public function report($id)
    {

        return response()->json(Registration::with('classroom', 'student')->where('classroom_id', $id)->get());
    }

    protected function allClassRooms()
    {
        return response()->json(Classroom::where('active', 1)->get());
    }
}
