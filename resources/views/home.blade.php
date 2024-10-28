@extends('layouts.main')

@section('home')
    <h2 class="text-center">Login</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none; margin: 0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="border p-3 rounded shadow-sm">
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
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="{{ route('registration.index') }}" class="text-decoration-none">Don't have an account?</a>
        </div>
    </form>
@endsection