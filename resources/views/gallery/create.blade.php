@extends('layout.master')

@section('title', 'Create Book')

@section('content')
    <h4 class="text-center my-5">Tambah Data Post</h4>
    <form action="{{route('gallery.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" placeholder="Title" required>
            @if ($errors->has('title'))
            <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Picture</label>
            <input name="picture" type="file" class="form-control">
            @if ($errors->has('picture'))
            <span class="text-danger">{{ $errors->first('picture') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="description" type="text" class="form-control" placeholder="Description" required>
            @if ($errors->has('description'))
            <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <div class="mt-4 d-flex justify-between justify-content-between">
            <a href="{{route('gallery.index')}}" class="btn px-4 btn-danger">Kembali</a>
            <input type="submit" class="btn px-4 btn-primary">
        </div>
    </form>
@endsection