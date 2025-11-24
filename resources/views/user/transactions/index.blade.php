@extends('layouts.app')

@section('title', 'Transaction History')
@section('page-title', 'Transaction History')

@section('content')
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#purchases">Purchases</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#sales">Sales</a>
    </li>
</ul>

<div class="tab-content">
    <div id="purchases" class="tab-pane fade show active">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Your Purchases & Trades</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Seller</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchased as $transaction)
                            <tr>
                                <td>{{ $transaction->item->name }}</td>
                                <td>{{ $transaction->seller->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $transaction->isBuyType() ? 'info' : 'success' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>${{ number_format($transaction->total_price, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ match($transaction->status) {
                                        'pending' => 'warning',
                                        'accepted' => 'info',
                                        'completed' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary'
                                    } }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('user.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No purchases yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($purchased->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $purchased->links() }}
            </div>
        @endif
    </div>

    <div id="sales" class="tab-pane fade">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sales Requests</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Buyer</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sold as $transaction)
                            <tr>
                                <td>{{ $transaction->item->name }}</td>
                                <td>{{ $transaction->buyer->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $transaction->isBuyType() ? 'info' : 'success' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>${{ number_format($transaction->total_price, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ match($transaction->status) {
                                        'pending' => 'warning',
                                        'accepted' => 'info',
                                        'completed' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary'
                                    } }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('user.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No sales yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($sold->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $sold->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Keep active tab on page reload
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
@endpush
