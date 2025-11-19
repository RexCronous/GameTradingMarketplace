@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Item</h1>

    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-2">
            <label class="block">Name</label>
            <input name="name" value="{{ $item->name }}" class="w-full border p-2" required>
        </div>
        <div class="mb-2">
            <label class="block">Description</label>
            <textarea name="description" class="w-full border p-2" required>{{ $item->description }}</textarea>
        </div>
        <div class="mb-2">
            <label class="block">Price</label>
            <input type="number" name="price" value="{{ $item->price }}" class="w-full border p-2" required>
        </div>
        <div class="mb-2">
            <label class="block">Image</label>
            <input type="file" name="image" accept="image/*">
            @if($item->image_path)
                <div class="mt-2"><img src="{{ asset('storage/' . $item->image_path) }}" style="max-height:120px"></div>
            @endif
        </div>
        <div>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Update</button>
        </div>
    </form>
@endsection
