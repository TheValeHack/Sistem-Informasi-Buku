@extends('layout.master')

@section('title', 'Edit Book')

@section('content')
    <h4 class="text-center my-5">Ubah Data Post</h4>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message}}
        </div>
    @endif
    <form action="{{route('gallery.update', $post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" placeholder="Title" value="{{ $post->title }}" required>
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
            @if ($post->picture != "noimage.png")
            <span class="badge-success"></span>
            @endif
            <button class="btn btn-danger delete-btn py-1 px-2 mt-2" style="font-size:10px;" data-id="{{ $post->id }}">
                Hapus gambar
            </button>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="description" type="text" class="form-control" placeholder="Description" value="{{ $post->description }}" required>
            @if ($errors->has('description'))
            <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <div class="mt-4 d-flex justify-between justify-content-between">
            <a href="{{route('gallery.index')}}" class="btn px-4 btn-danger">Kembali</a>
            <input type="submit" class="btn px-4 btn-primary">
        </div>
    </form>
    <form id="delete-form" action="{{ route('gallery.destroyImage', $post->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('after-script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                
                const bookId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus gambar?',
                    text: "Gambar yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
                });
            });
        });
    });
</script>

@endpush