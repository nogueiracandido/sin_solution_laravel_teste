@extends('layouts.app')

@section('content')
<adress-list-component :adresses="{{ $adresses }}" />
@endsection
