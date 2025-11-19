@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Items</h1>
        <a href="{{ route('items.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Add Item</a>
    </div>

    <table class="w-full bg-white shadow-sm">
        <thead>
            <tr class="text-left">
                <th class="p-2">Name</th>
                <th class="p-2">Owner</th>
                <th class="p-2">Price</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td class="p-2">{{ $item->name }}</td>
                    <td class="p-2">{{ optional($item->owner)->name }}</td>
                    <td class="p-2">{{ $item->price }}</td>
                    <td class="p-2">{{ $item->status }}</td>
                    <td class="p-2">
                        <a href="{{ route('items.show', $item->id) }}" class="mr-2">View</a>
                        @can('update', $item)
                            <a href="{{ route('items.edit', $item->id) }}" class="mr-2">Edit</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
