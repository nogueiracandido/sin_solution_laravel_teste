@extends('layouts.app')

@section('content')
<student-edit-component :student="{{ $student }}" />
@endsection