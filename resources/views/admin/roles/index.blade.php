@extends('layouts.admin')

@section('content')
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Create Role</a>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Name</th><th>Label</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->label }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $roles->links() }}
@endsection
