@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 shadow-sm">
        <h1 class="text-xl font-bold">{{ $item->name }}</h1>
        <div class="mt-2">{{ $item->description }}</div>
        <div class="mt-2">Price: {{ $item->price }}</div>
        <div class="mt-2">Status: {{ $item->status }}</div>
        @if($item->image_path)
            <div class="mt-4"><img src="{{ asset('storage/' . $item->image_path) }}" style="max-width:300px"></div>
        @endif
        @can('update', $item)
            <div class="mt-4">
                <a href="{{ route('items.edit', $item->id) }}" class="bg-yellow-500 px-3 py-1 text-white rounded">Edit</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline">@csrf @method('DELETE')<button class="bg-red-600 px-3 py-1 text-white rounded">Delete</button></form>
            </div>
        @endcan
    </div>
@endsection
