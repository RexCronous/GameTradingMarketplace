@extends('layouts.app')

@section('title', 'Edit Item')
@section('page-title', 'Edit Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Item</h3>
            </div>
            <form action="{{ route('user.items.update', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Item Name *</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $item->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" 
                               value="{{ old('category', $item->category) }}">
                        @error('category')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price *</label>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price', $item->price) }}" step="0.01" min="0" required>
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity', $item->quantity) }}" min="1" required>
                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        @if($item->image)
                            <div class="mb-2">
                                <img src="{{ $item->getImageUrl() }}" alt="{{ $item->name }}" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Item</button>
                    <a href="{{ route('user.items.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
