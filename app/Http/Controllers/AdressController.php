<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Student;

class AdressController extends Controller
{
    public function index()
    {
        return view('adress.index')->with('adresses', Address::with('student')->where('active', 1)->get());
    }

    public function create()
    {
        return view('adress.create')->with('students', Student::where('active', 1)->get(['name', 'id']));
    }

    public function store(Request $request)
    {
        Address::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Endereço cadastrado com sucesso!'
        ]);
    }

    public function edit($id)
    {
        return view('adress.edit')
            ->with('adress', Address::with('student')->where('id', $id)->get())
            ->with('students', Student::where('active', 1)->get(['name', 'id']));
    }

    public function update(Request $request)
    {
        Address::where('id', $request->id)->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Endereço atualizado com sucesso!'
        ]);
    }


    public function destroy(Request $request)
    {
        Address::where('id', $request->id)->update(['active' => 0]);

        return $this->allAdresses();
    }

    protected function allAdresses()
    {
        return response()->json(Address::with('student')->where('active', 1)->get());
    }
}
