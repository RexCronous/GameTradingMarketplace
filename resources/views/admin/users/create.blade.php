@extends('layouts.admin')

@section('content')
    <h3>Create User</h3>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="form-group"><label>Password</label><input name="password" type="password" class="form-control" required></div>
        <div class="form-group"><label>Roles</label><select name="roles[]" class="form-control" multiple>@foreach($roles as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach</select></div>
        <button class="btn btn-primary mt-2">Create</button>
    </form>
@endsection
