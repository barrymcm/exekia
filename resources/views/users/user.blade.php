@extends('layouts.app')

@section('title', 'Users')

@section('content')
    @foreach($users as $user)
        <ul>
            <li>{{ $user->first_name }} {{ $user->last_name }}</li>
            <li><a href="{{ route('user.show', $user->id) }}">Show users details</a></li>
            <li></li>
        </ul>
    @endforeach

    <a href="{{ route('user.create') }}">Create new user</a>
@endsection
