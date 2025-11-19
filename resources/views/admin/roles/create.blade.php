@extends('layouts.admin')

@section('content')
    <h3>Create Role</h3>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="form-group"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="form-group"><label>Label</label><input name="label" class="form-control"></div>
        <button class="btn btn-primary mt-2">Create</button>
    </form>
@endsection
