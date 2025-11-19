@extends('layouts.admin')

@section('content')
    <h3>Edit Role</h3>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group"><label>Name</label><input name="name" class="form-control" value="{{ $role->name }}" required></div>
        <div class="form-group"><label>Label</label><input name="label" class="form-control" value="{{ $role->label }}"></div>
        <button class="btn btn-primary mt-2">Save</button>
    </form>
@endsection
