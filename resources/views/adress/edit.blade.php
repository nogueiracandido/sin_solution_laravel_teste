@extends('layouts.app')

@section('content')
<adress-edit-component :adress="{{ $adress }}" :all_students="{{ $students }}" />
@endsection