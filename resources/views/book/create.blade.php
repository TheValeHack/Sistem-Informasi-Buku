@extends('layout.master')

@section('title', 'Create Book')

@section('content')
    <h4 class="text-center my-5">Tambah Data Buku</h4>
    <form action="{{route('books.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input name="judul" type="text" class="form-control" placeholder="Judul Buku" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input name="penulis" type="text" class="form-control" placeholder="Penulis" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input name="harga" type="number" class="form-control" placeholder="Harga" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Terbit</label>
            <input name="tgl_terbit" type="date" class="form-control" required>
        </div>
        <div class="mt-4 d-flex justify-between justify-content-between">
            <a href="{{route('books.index')}}" class="btn px-4 btn-danger">Kembali</a>
            <input type="submit" class="btn px-4 btn-primary">
        </div>
    </form>
@endsection