@extends('layoutbootstrap')
@section('content')
<div class="container">
    <h1>Account Settings</h1>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form untuk update profile -->
    <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <hr>

    <!-- Form untuk update logo -->
    <form action="{{ route('settings.updateLogo') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Logo</button>
    </form>

    <hr>

    <!-- Tautan ke halaman lain -->
    <a href="{{ route('settings.about') }}">About Us</a> | 
    <a href="{{ route('settings.help') }}">Help</a> | 
    <a href="{{ route('settings.security') }}">Security</a>
</div>
@endsection
