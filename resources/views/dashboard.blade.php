@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div>
        @foreach ($users as $user)
            <h1>
                {{ $user->name }}
            </h1>
        @endforeach
    </div>
@endsection
