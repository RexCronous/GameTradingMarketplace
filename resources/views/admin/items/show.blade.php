@extends('layouts.app')

@section('title', 'Item Details')
@section('page-title', 'Item: ' . $item->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                @if($item->image)
                    <img src="{{ $item->getImageUrl() }}" class="img-fluid" alt="{{ $item->name }}">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-white"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $item->name }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Owner:</strong></td>
                        <td><a href="{{ route('admin.users.show', $item->user) }}">{{ $item->user->name }}</a></td>
                    </tr>
                    <tr>
                        <td><strong>Price:</strong></td>
                        <td>${{ number_format($item->price, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td>{{ $item->category ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Quantity:</strong></td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge badge-{{ $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $item->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <h6>Description</h6>
                    <p>{{ $item->description ?? 'No description provided' }}</p>
                </div>

                <form action="{{ route('admin.items.destroy', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete Item
                    </button>
                    <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Back to Items</a>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Related Transactions</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($item->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->buyer->name }}</td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No transactions</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
