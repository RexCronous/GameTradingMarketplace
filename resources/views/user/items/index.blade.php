@extends('layouts.app')

@section('title', 'My Items')
@section('page-title', 'My Items')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('user.items.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Your Items</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->name }}</strong>
                                    </td>
                                    <td>{{ Str::limit($item->description, 50) }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->category ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning')
                                        }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.items.edit', $item) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user.items.destroy', $item) }}" method="POST" style="display:inline;">
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
                                    <td colspan="6" class="text-center text-muted">No items yet. <a href="{{ route('user.items.create') }}">Create one</a></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($items->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
