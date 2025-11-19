@extends('layouts.admin')

@section('content')
    <h3>Edit User</h3>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group"><label>Name</label><input name="name" class="form-control" value="{{ $user->name }}" required></div>
        <div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" value="{{ $user->email }}" required></div>
        <div class="form-group"><label>Password (leave blank to keep)</label><input name="password" type="password" class="form-control"></div>
        <div class="form-group"><label>Roles</label><select name="roles[]" class="form-control" multiple>@foreach($roles as $r)<option value="{{ $r->id }}" @if($user->roles->contains($r->id)) selected @endif>{{ $r->name }}</option>@endforeach</select></div>
        <button class="btn btn-primary mt-2">Save</button>
    </form>
@endsection
