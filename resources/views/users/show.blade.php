@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div>
        <p>Name : {{ $user->first_name }} {{ $user->last_name }}</p>
        <p>Dob : {{ $user->dob }}</p>
        <p>Contact Number : {{ $user->contact_number }}</p>
        <p>Profession : {{ $user->profession }}</p>

        {{-- hack : I can't get the user model to reference the currency relation through the rate --}}
        {{-- ie $user->rate->currency->currency --}}
        @foreach ($currencies as $currency)
            @if ($currency->id == $user->rate->currency_id)
                    <p>Rates [Hourly] : {{ $user->rate->hourly }}</p>
                    <p>Currency : {{ $currency->currency }}</p>
            @endif
        @endforeach
    </div>

    <a href="{{ route('user.index') }}">Home</a>
@endsection
