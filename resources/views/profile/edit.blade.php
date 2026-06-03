@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="mb-6">
            <h1 class="luxury-heading text-3xl">My Profile</h1>
            <p class="text-gray-600 mt-2">
                View and manage your ALKEMEA Hotel account information.
            </p>
        </div>

        {{-- User Account Details --}}
        <div class="luxury-card p-6 mb-6">
            <h2 class="luxury-card-title text-xl mb-4">Account Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Full Name</p>
                    <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Email Address</p>
                    <p class="font-bold text-lg">{{ auth()->user()->email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Account Type</p>
                    <p class="font-bold text-lg">{{ ucfirst(auth()->user()->role) }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Date Registered</p>
                    <p class="font-bold text-lg">
                        {{ auth()->user()->created_at ? auth()->user()->created_at->format('F d, Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Reservation Summary --}}
        <div class="luxury-card p-6 mb-6">
            <h2 class="luxury-card-title text-xl mb-4">Reservation Summary</h2>

            @php
                $user = auth()->user();
                $totalReservations = \App\Models\Reservation::where('user_id', $user->id)->count();
                $pendingReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'pending')->count();
                $approvedReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'approved')->count();
                $cancelledReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'cancelled')->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="luxury-card p-4">
                    <p class="text-sm text-gray-600">Total Reservations</p>
                    <p class="text-2xl font-bold luxury-gold-text">{{ $totalReservations }}</p>
                </div>

                <div class="luxury-card p-4">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold luxury-gold-text">{{ $pendingReservations }}</p>
                </div>

                <div class="luxury-card p-4">
                    <p class="text-sm text-gray-600">Approved</p>
                    <p class="text-2xl font-bold luxury-gold-text">{{ $approvedReservations }}</p>
                </div>

                <div class="luxury-card p-4">
                    <p class="text-sm text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold luxury-gold-text">{{ $cancelledReservations }}</p>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('reservations.index') }}" class="btn-navy">
                    View My Reservations
                </a>
            </div>
        </div>

        {{-- Update Profile --}}
        <div class="luxury-card p-6 mb-6">
            <h2 class="luxury-card-title text-xl mb-4">Update Profile Information</h2>

            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Update Password --}}
        <div class="luxury-card p-6 mb-6">
            <h2 class="luxury-card-title text-xl mb-4">Update Password</h2>

            @include('profile.partials.update-password-form')
        </div>

        {{-- Delete Account --}}
        <div class="luxury-card p-6">
            <h2 class="luxury-card-title text-xl mb-4">Delete Account</h2>

            @include('profile.partials.delete-user-form')
        </div>

        <div class="mt-6">
            <a href="{{ route('home') }}" class="btn-navy">
                Back to Rooms
            </a>
        </div>
    </div>
</div>
@endsection