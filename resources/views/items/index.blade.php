@extends('layouts.app')

@section('page-title', 'My Items')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">My Items</h3>
                <a href="{{ route('items.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Create Item
                </a>
            </div>
            <div class="card-body">
                @forelse($items as $item)
                    <div class="row mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ $item->getImageUrl() }}" alt="{{ $item->name }}" class="img-fluid rounded" style="height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-md-7">
                            <h5>{{ $item->name }}</h5>
                            <p class="text-muted">{{ Str::limit($item->description, 100) }}</p>
                            <p><strong>Price:</strong> ${{ number_format($item->price, 2) }}</p>
                            <span class="badge badge-{{ $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        <div class="col-md-3 text-right">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-info">View</a>
                            @if($item->status === 'available')
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('items.destroy', $item) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-5">You haven't created any items yet. <a href="{{ route('items.create') }}">Create one now!</a></p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
