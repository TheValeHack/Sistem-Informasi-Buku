@extends('layout.master')

@section('title', 'Profil')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="{{ route('profil.destroy', $user->id) }}" class="w-full bg" id="delete-form">
                    @csrf
                    @method('DELETE')
                    
                </form>
                <form action="{{ route('profil.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="card-header d-flex flex-column align-items-center justify-content-center">
                  <div class="profil-picture my-3">
                    <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://www.pngitem.com/pimgs/m/579-5798505_user-placeholder-svg-hd-png-download.png' }}" class="border rounded-circle cover object-fit-cover" width="120px" height="120px" alt="Profil Picture">
                  </div>
                  <div class="mb-3 row">
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old ('photo') }}" placeholder="Masukkan Foto...">
                        @if ($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                        @endif
                </div>
                </div>
                <div class="card-body">
                    <button class="btn btn-danger mb-3" id="delete-btn" type="button">Delete Account</button>
                    <h4 class="card-title">Profil</h4>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="name" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" aria-label="Disabled input email" disabled readonly>
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{ route('profil.index') }}" class="btn btn-secondary text-white px-4">Cancel</a>
                            <button type="submit" class="btn btn-info text-white px-4">Submit</button>
                        </div>
                    </div>
                </div>
              </div>
            </form>
        </div>
    </div>
@endsection

@push('after-script')
<script>
    const deleteButton = document.getElementById('delete-btn');
    

    deleteButton.addEventListener('click', function (event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus akun?',
            text: "Akun yang dihapus tidak dapat dikembalikan!",
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
</script>

@endpush