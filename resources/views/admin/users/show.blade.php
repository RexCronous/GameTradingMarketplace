@extends('layouts.main')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td><span class="badge badge-{{ $user->isAdmin() ? 'danger' : 'info' }}">{{ ucfirst($user->role) }}</span></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->profile->username ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Bio</th>
                            <td>{{ $user->profile->bio ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Joined</th>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistics</h3>
                </div>
                <div class="card-body">
                    <p><strong>Total Items:</strong> {{ $user->items_count }}</p>
                    <p><strong>Items Bought:</strong> {{ $user->transactions_bought_count }}</p>
                    <p><strong>Items Sold:</strong> {{ $user->transactions_sold_count }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Delete this user?')">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>
</div>
@endsection
