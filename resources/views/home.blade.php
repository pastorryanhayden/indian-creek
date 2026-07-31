@extends('layouts.main')

@section('title', 'Home')

@section('content')
@include('home.hero')
@include('home.stats')
@include('home.camp-types')
@include('home.other-events')
@include('home.map')
@include('home.speakers')

@endsection
