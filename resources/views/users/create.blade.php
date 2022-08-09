@extends('layouts.app')

@section('title', 'Create User')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-10 col-lg-3">
        <h4 class="mb-3">Create new user</h4>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
{{--            <input type="hidden" id="user_id" name="user_id" value="{{ $user }}">--}}
            <label for="first_name">First Name</label>
            <input class="form-control" type="text" name="first_name" value="">
            <label for="last_name">Last Name</label>
            <input class="form-control" type="text" name="last_name" value="">
            <label for="contact_number">Contact Number</label>
            <input class="form-control" type="text" name="contact_number" value="">
            {{-- Need to fix selection so that future dates cannot be selected --}}
            <label for="dob">DOB</label>
            <input class="form-control" type="date" name="dob" value="">
            <label for="profession">Profession</label>
            <input class="form-control" type="text" name="profession" value="">
            <label for="rate">Rate</label>
            <input class="form-control" type="text" name="rate" value="">
            <label class="form-label" for="currency">Currency</label>
            <select class="form-control" name="currency" id="currency">
                @foreach($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->currency }}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" name="Submit">
        </form>
    </div>

    <a href="{{ route('user.index') }}">Home</a>
@endsection
