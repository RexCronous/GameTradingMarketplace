@extends('layouts.app')

@section('title', 'Manage Items')
@section('page-title', 'Manage Items')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Items</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>#{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>
                            <span class="badge badge-{{ $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->category ?? 'N/A' }}</td>
                        <td>{{ $item->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.items.show', $item) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($items->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $items->links() }}
    </div>
@endif
@endsection
