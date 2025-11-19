@extends('layouts.admin')

@section('content')
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create User</a>
    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Roles</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->roles->pluck('name')->join(', ') }}</td>
                <td>
                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('users.destroy', $u->id) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
