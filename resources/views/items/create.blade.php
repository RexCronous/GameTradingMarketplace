@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Create Item</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm">
        @csrf
        <div class="mb-2">
            <label class="block">Name</label>
            <input name="name" class="w-full border p-2" required>
        </div>
        <div class="mb-2">
            <label class="block">Description</label>
            <textarea name="description" class="w-full border p-2" required></textarea>
        </div>
        <div class="mb-2">
            <label class="block">Price</label>
            <input type="number" name="price" class="w-full border p-2" required>
        </div>
        <div class="mb-2">
            <label class="block">Image</label>
            <input type="file" name="image" accept="image/*" required>
        </div>
        <div>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Create</button>
        </div>
    </form>
@endsection
