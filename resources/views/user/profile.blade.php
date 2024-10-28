@extends('layouts.main')

@section('profile')
    <h1 class="text-center">Welcome {{ session('user') }}</h1>
    <form action="{{route('logout')}}" method="post">
        @csrf
        <input type="hidden" name="username" value="{{ session('user') }}">
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-danger">Logout</button>
        </div>
    </form>
@endsection