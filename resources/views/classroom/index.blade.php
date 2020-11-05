@extends('layouts.app')

@section('content')
<classroom-list-component :classrooms=" {{ $classrooms }} "/>
@endsection
