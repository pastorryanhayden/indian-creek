@extends('layouts.main')

@section('title', 'Home')

@section('content')
@include('home.hero')
@include('home.camp-types')
@include('home.map')
@include('home.other-events')
@include('home.speakers')

@endsection
