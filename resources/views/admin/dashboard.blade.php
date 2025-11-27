@extends('layouts.app')

@section('page-title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_users'] ?? 0 }}</h3>
                <p>Total Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['total_items'] ?? 0 }}</h3>
                <p>Total Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="{{ route('admin.items.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['completed_trades'] ?? 0 }}</h3>
                <p>Completed Trades</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['pending_trades'] ?? 0 }}</h3>
                <p>Pending Offers</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Transactions</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_transactions ?? [] as $tx)
                            <tr>
                                <td>{{ $tx->item->name ?? 'N/A' }}</td>
                                <td>{{ $tx->buyer->name ?? 'N/A' }}</td>
                                <td>{{ $tx->seller->name ?? 'N/A' }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($tx->type) }}</span></td>
                                <td><span class="badge badge-{{ $tx->status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($tx->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No transactions</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Users</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Items</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_users ?? [] as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->items()->count() }}</td>
                                <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No users</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
