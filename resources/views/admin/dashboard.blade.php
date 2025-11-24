@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">Manage Users <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalItems }}</h3>
                    <p>Total Items</p>
                </div>
                <div class="icon"><i class="fas fa-box"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalTransactions }}</h3>
                    <p>Total Transactions</p>
                </div>
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $pendingTransactions }}</h3>
                    <p>Pending</p>
                </div>
                <div class="icon"><i class="fas fa-hourglass-half"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Transactions</h3>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Buyer</th>
                                        <th>Seller</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $tx)
                                    <tr>
                                        <td>{{ $tx->item->name }}</td>
                                        <td>{{ $tx->buyer->name }}</td>
                                        <td>{{ $tx->seller->name }}</td>
                                        <td><span class="badge badge-{{ $tx->type === 'buy' ? 'info' : 'primary' }}">{{ ucfirst($tx->type) }}</span></td>
                                        <td>₱{{ number_format($tx->total_price ?? $tx->offer_amount ?? 0, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $tx->status === 'pending' ? 'warning' : 
                                                ($tx->status === 'completed' ? 'success' : 'danger')
                                            }}">{{ ucfirst($tx->status) }}</span>
                                        </td>
                                        <td>{{ $tx->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No transactions yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Statistics</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Items</th>
                                        <th>Bought</th>
                                        <th>Sold</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td><strong>{{ $user->name }}</strong></td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge badge-{{ $user->isAdmin() ? 'danger' : 'info' }}">{{ ucfirst($user->role) }}</span></td>
                                        <td>{{ $user->items_count }}</td>
                                        <td>{{ $user->transactions_bought_count }}</td>
                                        <td>{{ $user->transactions_sold_count }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links() }}
                    @else
                        <p class="text-muted">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
