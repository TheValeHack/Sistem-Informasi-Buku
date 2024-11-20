@extends('layout.master')

@section('title', 'Gallery')

@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <a class="btn btn-primary float-end" href="{{route("gallery.create")}}">Tambah Post</a>
    </div>

</div>

<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Gallery</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message}}
                </div>
                @elseif ($message = Session::get('error'))
                <div class="alert alert-danger">
                    {{ $message}}
                </div>
                @endif
                <div class="row" id="gallery-container"></div>  
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const galleryContainer = document.getElementById('gallery-container');

        async function loadGallery() {
            try {
                const response = await fetch('/api/gallery');
                const data = await response.json();

                if (!Array.isArray(data) || data.length === 0) {
                    galleryContainer.innerHTML = '<h3>Tidak ada data</h3>';
                    return;
                }

                galleryContainer.innerHTML = '';

                data.forEach(gallery => {
                    const galleryHtml = `
                        <div class="col-sm-2">
                            <div class="p-3 rounded" style="background:rgba(0,0,0,0.02);">
                                <a href="/storage/posts_image/${gallery.picture}" class="example-image-link" style="text-decoration:none" data-lightbox="roadtrip" data-title="${gallery.description}">
                                    <img src="/storage/posts_image/${gallery.picture}" alt="${gallery.title}" class="example-image img-fluid mb-2">
                                    <div class="text-black" style="text-decoration:none;text-size:16px;">${gallery.title}</div>
                                </a>
                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-info rounded-circle text-white ms-2" onclick="window.location.href='/gallery/update/${gallery.id}'" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                      </svg></button>
                                    <button class="btn btn-danger rounded-circle delete-btn" data-id="${gallery.id}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg></button>
                                    <form id="delete-form-${gallery.id}" action="/gallery/${gallery.id}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                    galleryContainer.insertAdjacentHTML('beforeend', galleryHtml);

                    const deleteButtons = document.querySelectorAll('.delete-btn');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function (event) {
                            event.preventDefault();
                            
                            const bookId = this.getAttribute('data-id');

                            Swal.fire({
                                title: 'Apakah anda yakin ingin menghapus?',
                                text: "Data yang dihapus tidak dapat dikembalikan!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + bookId).submit();
                                }
                            });
                        });
                    });

                });
            } catch (error) {
                console.error(error);
            }
        }

        loadGallery();
    });
</script>

@endpush