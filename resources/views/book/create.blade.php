@extends('layout.master')

@section('title', 'Create Book')

@section('content')
    <h4 class="text-center my-5">Tambah Data Buku</h4>
    <form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input name="judul" type="text" class="form-control" placeholder="Judul Buku" required>
            @if ($errors->has('judul'))
            <span class="text-danger">{{ $errors->first('judul') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Photo Buku</label>
            <input name="photo" type="file" class="form-control">
            @if ($errors->has('photo'))
            <span class="text-danger">{{ $errors->first('photo') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input name="penulis" type="text" class="form-control" placeholder="Penulis" required>
            @if ($errors->has('penulis'))
            <span class="text-danger">{{ $errors->first('penulis') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input name="harga" type="number" class="form-control" placeholder="Harga" required>
            @if ($errors->has('harga'))
            <span class="text-danger">{{ $errors->first('harga') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Terbit</label>
            <input name="tgl_terbit" type="date" class="form-control" required>
            @if ($errors->has('tgl_terbit'))
            <span class="text-danger">{{ $errors->first('tgl_terbit') }}</span>
            @endif
        </div>
        <div class="mt-4 d-flex justify-between justify-content-between">
            <a href="{{route('books.index')}}" class="btn px-4 btn-danger">Kembali</a>
            <input type="submit" class="btn px-4 btn-primary">
        </div>
    </form>
@endsection