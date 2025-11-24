@extends('layouts.main')

@section('title', 'Edit Item: ' . $item->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Item</h3>
                </div>
                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Item Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $item->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5" required>{{ old('description', $item->description) }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Price (₱) *</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" step="0.01" min="0" value="{{ old('price', $item->price) }}" required>
                            @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Item Image</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" accept="image/*">
                                <label class="custom-file-label" for="image">Choose image (optional)</label>
                            </div>
                            @error('image')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            <small class="text-muted">Max 5MB. Leave empty to keep current image.</small>
                        </div>

                        @if($item->image)
                        <div class="form-group">
                            <label>Current Image:</label>
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Current" style="max-width: 200px; max-height: 200px;">
                        </div>
                        @endif

                        <div class="form-group">
                            <img id="preview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; display: none; margin-top: 10px;">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Item
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection
