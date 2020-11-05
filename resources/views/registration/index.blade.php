@extends('layouts.app')

@section('content')
<registration-list-component :registration="{{ $registration }}" />
@endsection
