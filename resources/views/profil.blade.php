@extends('layouts.master_dashboard')
@section('content')
<main class="profil">
    <div class="container">
        <div class="card">
            <div class="card-body p-4">
                
                <form action="{{route('profil.update')}}" class="row p-2" method="POST" enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="col-md-12">
                        @if(Session::has('delete'))
                            <small class="text-success mb-5">{!! Session::get('delete') !!}</small>
                        @elseif(Session::has('updated'))
                            <small class="text-success mb-5">{!! Session::get('updated') !!}</small>
                        @endif
                    </div>
                    <div class="d-flex text-black mt-3">
                        <div class="flex-shrink-0">
                            @if (!empty($user->photo_profile))
                            <img class="img-fluid border-0 photo-profile" width="280px" src="data:image/jpeg;base64,{{ base64_encode($user->photo_profile) }}">
                            @else
                                <img class="img-fluid border-0 photo-profile" width="180px" src="{{ asset('images/people.png') }}">
                            @endif

                            <div class="form-group mt-3">
                                <label for="photo_profile" class="form-label">Photo profil</label>
                                <input type="file" class="form-control form-control-sm" id="photo_profile" name="photo_profile">
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4 mt-4">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control form-control-sm" id="username" name="username" value="{{old('username', $user->username)}}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control form-control-sm" id="email" name="email" value="{{old('email', $user->email)}}">
                            </div>
                            <div class="form-group d-grid gap-2 d-md-flex justify-content-md-end mt-5 mb-2">
                                <button type="submit" class="btn btn-sm btn-success">Update profil</button>
                                <a href="{{route('photo.create')}}" class="btn btn-sm btn-outline-dark me-1">Submit photo</a>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
        @if(count($photos) > 0)
        <div class="gallery py-5">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        @foreach ($photos as $key => $photo)
                        <div class="col">
                            <div class="card card-gallery shadow-sm">
                                <img class="bd-placeholder-img card-img-top card-gallery-img" width="100%" height="300" src="data:image/jpeg;base64,{{ base64_encode($photo->photo) }}" alt="">
                                <a class="" data-bs-toggle="modal" data-bs-target="#photo{{$photo->id}}" data-bs-whatever="@mdo">
                                    <div class="card-gallery-overlay">
                                    </div>
                                </a>
                                <div class="card-text card-gallery-text">
                                    <div class="d-flex gap-1 justify-content-between row">
                                        <div class="col-md-6">
                                            @if (!empty($user->photo_profile))
                                                <img class="img-fluid border-0 icon-profil" src="data:image/jpeg;base64,{{ base64_encode($user->photo_profile) }}">
                                            @else
                                                <img class="img-fluid border-0 icon-profil" src="{{ asset('images/people.png') }}">
                                            @endif
                                            <small class="text-light">
                                                {{$user->username}}
                                            </small>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="d-grid gap-1 d-md-flex justify-content-md-end">
                                                <a href="{{route('photo.detail', $photo->id)}}" class="btn btn-sm btn-light text-secondary">
                                                    <i class="bi bi-search"></i>
                                                </a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-light text-secondary" data-bs-toggle="modal" data-bs-target="#deletePhoto{{$photo->id}}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                                
                                <!-- Modal Photos -->
                                <div class="modal" id="photo{{$photo->id}}" tabindex="-1" aria-labelledby="photoLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-photos modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 mb-4">
                                                @if (!empty($user->photo_profile))
                                                    <img class="img-fluid border-0 icon-profil" src="data:image/jpeg;base64,{{ base64_encode($user->photo_profile) }}">
                                                @else
                                                    <img class="img-fluid border-0 icon-profil" src="{{ asset('images/people.png') }}">
                                                @endif
                                                <p class="modal-title ms-2 fw-bold" id="photoLabel">
                                                    {{$user->username}} 
                                                    <span class="text-mute fw-lighter photo-date"> &#x25CF; {!! \Carbon\Carbon::parse(old('date', $photo->created_at))->formatLocalized('%d %b %Y %H:%M') !!}</span>
                                                </p>
                                                <button type="button" class="btn-close bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body bg-white">
                                                <div class="row">
                                                    <div class="col-md-10 mx-auto">
                                                        <a href="#">
                                                            <img src="data:image/jpeg;base64,{{ base64_encode($photo->photo) }}" alt="" width="100%" class="m-0">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-12 p-3">
                                                        <p class="mt-1 fw-bold fs-5">
                                                            {{$user->username}}
                                                            <span class="fw-lighter text-muted fs-6 me-1">{{$photo->caption}}</span>
                                                        </p>
                                                        @if(!empty($photo->tags))
                                                            @foreach ($photo->tags as $tag)
                                                                <button type="button" class="btn btn-sm btn-secondary mb-2 disabled">{{ $tag->name }}</button>
                                                            @endforeach
                                                        @endif
                                                        <div class="d-grid gap-1 d-md-flex mt-3">
                                                            <form action="{{ route('photo.like',  $photo->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-light"><i class="bi bi-suit-heart-fill me-1"></i> {{$photo->likes}} Likes</button>
                                                            </form>
                                                            <form action="{{ route('photo.unlike',  $photo->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-light"><i class="bi bi-suit-heart me-1"></i> Unlikes</button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Delete Photo-->
                                <div class="modal" id="deletePhoto{{$photo->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletePhotoLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="deletePhotoLabel">
                                                    <i class="bi bi-trash3-fill me-2"></i> Delete Photo
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="{{route('photo.delete', $photo->id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p class="text-center">Apakah anda yakin ingin menghapus foto ini?</p>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between">
                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
</main>
@endsection