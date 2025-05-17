@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <p>Selamat datang, {{ auth()->user()->nama }}</p>
    </div>
@endsection
