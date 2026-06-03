@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-5xl mx-auto py-8 px-4">

        @if(auth()->user()->role === 'admin')
            {{-- ADMIN PROFILE --}}
            <div class="mb-6">
                <h1 class="luxury-heading text-3xl">Admin Profile</h1>
                <p class="text-gray-600 mt-2">
                    View and manage your ALKEMEA Hotel administrator account.
                </p>
            </div>

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Administrator Details</h2>

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
                        <p class="text-sm text-gray-600">Account Role</p>
                        <p class="font-bold text-lg">Administrator</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Date Registered</p>
                        <p class="font-bold text-lg">
                            {{ auth()->user()->created_at ? auth()->user()->created_at->format('F d, Y') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Admin Responsibilities</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="luxury-card p-4">
                        <p class="font-bold">Room Management</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Add, update, and manage hotel room information.
                        </p>
                    </div>

                    <div class="luxury-card p-4">
                        <p class="font-bold">Reservation Management</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Review, approve, and reject guest reservations.
                        </p>
                    </div>

                    <div class="luxury-card p-4">
                        <p class="font-bold">Payment Tracking</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Monitor guest payment methods and payment status.
                        </p>
                    </div>
                </div>
            </div>

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Update Admin Information</h2>

                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Update Password</h2>

                @include('profile.partials.update-password-form')
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="btn-navy">
                    Back to Admin Dashboard
                </a>
            </div>

        @else
            {{-- GUEST / USER PROFILE --}}
            <div class="mb-6">
                <h1 class="luxury-heading text-3xl">My Profile</h1>
                <p class="text-gray-600 mt-2">
                    View and manage your ALKEMEA Hotel account information.
                </p>
            </div>

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

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Reservation Summary</h2>

                @php
                    $user = auth()->user();

                    $totalReservations = \App\Models\Reservation::where('user_id', $user->id)->count();
                    $pendingReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'pending')->count();
                    $approvedReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'approved')->count();
                    $rejectedReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'rejected')->count();
                    $cancelledReservations = \App\Models\Reservation::where('user_id', $user->id)->where('status', 'cancelled')->count();
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="luxury-card p-4">
                        <p class="text-sm text-gray-600">Total</p>
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
                        <p class="text-sm text-gray-600">Rejected</p>
                        <p class="text-2xl font-bold luxury-gold-text">{{ $rejectedReservations }}</p>
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

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Update Profile Information</h2>

                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="luxury-card p-6 mb-6">
                <h2 class="luxury-card-title text-xl mb-4">Update Password</h2>

                @include('profile.partials.update-password-form')
            </div>

            <div class="luxury-card p-6">
                <h2 class="luxury-card-title text-xl mb-4">Delete Account</h2>

                @include('profile.partials.delete-user-form')
            </div>

            <div class="mt-6">
                <a href="{{ route('home') }}" class="btn-navy">
                    Back to Rooms
                </a>
            </div>
        @endif

    </div>
</div>
@endsection