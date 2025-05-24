@extends('layouts.main')

@section('title', 'Plan Your Camp Week')

@section('content')
    <div x-data="{ type: '{{ $defaultTypeId }}', week: '{{ $defaultWeekId }}', updateQueryParams() {
        const params = new URLSearchParams();
        if (this.type) params.set('type', this.type);
        if (this.week) params.set('week', this.week);
        history.pushState({}, '', '?' + params.toString());
    }
}">
        @include('camp.hero')
        @include('camp.camp-types')
        @include('camp.weeks')
        @include('camp.register-church')
        @include('camp.register-campers')
        @include('camp.enjoy-camp')
    </div>
@endsection
