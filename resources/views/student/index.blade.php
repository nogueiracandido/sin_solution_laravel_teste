@extends('layouts.app')

@section('content')
<student-list-component :students="{{ $students }}" />
@endsection
