@extends('layouts.app')

@section('content')
<registration-create-component :classrooms="{{ $classrooms }}" :students="{{ $students }}" />
@endsection