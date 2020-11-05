@extends('layouts.app')

@section('content')
<adress-create-component :all_students="{{ $students }}" />
@endsection