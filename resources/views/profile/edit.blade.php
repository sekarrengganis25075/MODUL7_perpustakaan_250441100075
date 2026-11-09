@extends('layouts.lunaria')

@section('title', 'Profil — Lunaria Library')

@push('before-styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endpush

@section('content')
    <h2 class="page-title">Profil Saya</h2>

    <div class="profile-stack">
        <div class="profile-card">
            <div class="profile-inner">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-inner">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-inner">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection