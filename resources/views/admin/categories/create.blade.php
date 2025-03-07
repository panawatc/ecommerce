@extends('admin.layouts.app')

@section('title', 'Add New Category')

@section('header', 'Add New Category')

@section('actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">
    <i class="bi bi-arrow-left"></i> Back to Categories
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                <small class="text-muted">The slug will be automatically generated from the name.</small>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
    </div>
</div>
@endsection