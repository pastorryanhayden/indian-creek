@extends('layouts.main')

@section('title', 'Plan Your Camp Week')

@section('content')
<div x-data="{
    type: (function() {
        const params = new URLSearchParams(window.location.search);
        const type = params.get('type');
        return ['teen', 'junior', 'combo'].includes(type) ? type : 'teen';
    })(),
    week: (function() {
        const params = new URLSearchParams(window.location.search);
        const week = params.get('week');
        return ['1', '2', '3', '4', '5', '6'].includes(week) ? week : '1';
    })()
}">
    @include('camp.hero')
    @include('camp.camp-types')
    @include('camp.weeks')
    @include('camp.register-church')
    @include('camp.register-campers')
    @include('camp.enjoy-camp')

</div>

@endsection
