@extends('layouts.app')

@section('title', 'Users')

@section('content')
<ul>
    <li>{{ $user->first_name }} {{ $user->last_name }}</li>
    <li><a href="{{ route('user.show', $user->id) }}">Show user details</a>
        <br>
    <li>Users hourly rate in : {{ $currency->currency }}</li>
</ul>

<a href="{{ route('user.create') }}">Create new user</a>
@endsection
