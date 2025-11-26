@extends('layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Your Profile</h3>
            </div>
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        @if($profile && $profile->avatar)
                            <div class="mb-2">
                                <img src="{{ $profile->getAvatarUrl() }}" alt="Avatar" style="max-width: 150px; border-radius: 50%;">
                            </div>
                        @endif
                        <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                        @error('avatar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" 
                               value="{{ old('username', $profile->username ?? '') }}" required>
                        @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="3">{{ old('bio', $profile->bio ?? '') }}</textarea>
                        @error('bio')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Account Statistics</h3>
            </div>
            <div class="card-body">
                <div class="description-block border-bottom">
                    <h5 class="description-header">{{ $user->items()->count() }}</h5>
                    <span class="description-text">Total Items</span>
                </div>

                <div class="description-block border-bottom">
                    <h5 class="description-header">{{ $user->items()->where('status', 'available')->count() }}</h5>
                    <span class="description-text">Available Items</span>
                </div>

                <div class="description-block border-bottom">
                    <h5 class="description-header">{{ $user->buyerTransactions()->where('status', 'completed')->count() }}</h5>
                    <span class="description-text">Completed Trades</span>
                </div>

                <div class="description-block">
                    <h5 class="description-header">${{ number_format($user->sellerTransactions()->where('status', 'completed')->sum('total_price'), 2) }}</h5>
                    <span class="description-text">Total Sales</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
