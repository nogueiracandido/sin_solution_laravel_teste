@extends('layouts.app')

@section('content')
<classroom-edit-component :classroom="{{ $classroom }}" />
@endsection