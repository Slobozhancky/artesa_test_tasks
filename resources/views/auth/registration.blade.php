@extends('layouts.main')

@section('registration')
    <h2 class="text-center">Registration</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none; margin: 0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('registration.store') }}" method="POST" class="border p-3 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="{{ route('home') }}" class="text-decoration-none">Have an account?</a>
        </div>
    </form>
@endsection