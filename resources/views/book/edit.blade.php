@extends('layout.master')

@section('title', 'Edit Book')

@section('content')
    <h4 class="text-center my-5">Ubah Data Buku</h4>
    <form action="{{route('books.update',$book->id)}}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input value="{{$book->judul}}" name="judul" type="text" class="form-control" placeholder="Judul Buku" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input value="{{$book->penulis}}" name="penulis" type="text" class="form-control" placeholder="Penulis" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input value="{{$book->harga}}" name="harga" type="number" class="form-control" placeholder="Harga" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Terbit</label>
            <input value="{{$book->tgl_terbit}}" name="tgl_terbit" type="date" class="form-control" required>
        </div>
        <div class="mt-4 d-flex justify-between justify-content-between">
            <a href="{{route('books.index')}}" class="btn px-4 btn-danger">Kembali</a>
            <input type="submit" class="btn px-4 btn-primary">
        </div>
    </form>
@endsection