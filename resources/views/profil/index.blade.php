@extends('layout.master')

@section('title', 'Profil')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                  <div class="profil-picture my-3">
                    <img src="{{ $user->photo ? asset('storage/'.$user->photo) :  asset('photos/user-placeholder.png') }}" class="border rounded-circle cover object-fit-cover" width="120px" height="120px" alt="Profil Picture">
                  </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Profil</h4>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" aria-label="Disabled input name" disabled readonly>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="name" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" aria-label="Disabled input email" disabled readonly>
                        </div>
                    </div>
                    <div class=" row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('profil.edit') }}" class="btn btn-info text-white px-4">Edit</a>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
@endsection