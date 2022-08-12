@extends('layouts.app')

@section('title', 'Users')

@section('content')
    @foreach($users as $user)
        <ul>
            <li>{{ $user->first_name }} {{ $user->last_name }}</li>
            <li>Hourly Rate : {{ $currencies->firstWhere('id', $user->rate->currency_id)->currency }} {{ $user->rate->hourly }}</li>
            <li><a href="{{ route('user.show', $user->id) }}">Show user details</a>
                <br>
            <li>Show users hourly rate in : </li>

            @foreach($currencies as $currency)
            <ul>
                @if($user->rate->currency_id != $currency->id)
                    <li>
                        <a href="{{ route("user.rate.currency", ['user' => $user->id, 'currency' => $currency->currency]) }}">
                            {{ $currency->currency }}
                        </a>
                    </li>
                @endif
            </ul>
            @endforeach
        </ul>
    @endforeach

    <a href="{{ route('user.create') }}">Create new user</a>
@endsection
