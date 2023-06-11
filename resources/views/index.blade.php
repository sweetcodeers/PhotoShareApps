@extends('layouts.master')
@section('navbar')
  @include('templates.navbar')
@endsection
@section('content')
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5 mt-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Our Gallery</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        @if ($isLogin)
            <a href="{{route('photo.create')}}" class="btn btn-sm btn-outline-dark">Submit photo</a>
        @else
            <a href="{{route('login')}}" class="btn btn-sm btn-outline-dark">Submit photo</a>
        @endif
      </div>
    </div>
  </section>
  
  @if(count($photos) > 0)
  <div class="gallery py-5 bg-light">
    <div class="container">
  
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          @foreach ($photos as $key => $photo)
          <div class="col">
            <div class="card card-gallery shadow-sm">
                <img class="bd-placeholder-img card-img-top card-gallery-img" width="100%" height="300" src="data:image/jpeg;base64,{{ base64_encode($photo->photo) }}">
                <a class="" data-bs-toggle="modal" data-bs-target="#photoModal{{$photo->id}}" data-bs-whatever="@mdo">
                  <div class="card-gallery-overlay"></div>
                </a>
                <div class="card-text card-gallery-text">
                  <div class="d-flex justify-content-between row">
                    <div class="col-md-6">
                        @if (!empty($photo->photo_profile))
                            <img class="img-fluid border-0 icon-profil" src="data:image/jpeg;base64,{{ base64_encode($photo->photo_profile) }}">
                        @else
                            <img class="img-fluid border-0 icon-profil" src="{{ asset('images/people.png') }}">
                        @endif
                        <small class="text-light">
                            {{$photo->username}}
                        </small>
                    </div>
                  </div>
                </div> 
  
                <!-- Modal Photos -->
                <div class="modal" id="photoModal{{$photo->id}}" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-photos modal-lg">
                        <div class="modal-content">
                            <div class="modal-header border-0 mb-4">
                                @if (!empty($photo->photo_profile))
                                    <img class="img-fluid border-0 icon-profil" src="data:image/jpeg;base64,{{ base64_encode($photo->photo_profile) }}">
                                @else
                                    <img class="img-fluid border-0 icon-profil" src="{{ asset('images/people.png') }}">
                                @endif
                                <p class="modal-title ms-2 fw-bold" id="photoLabel">
                                  {{$photo->username}} 
                                  <span class="text-mute fw-lighter photo-date"> &#x25CF; {{$date}}</span>
                                </p>
                                <button type="button" class="btn-close bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body bg-white p-0">
                                <div class="row">
                                    <div class="col-md-10 mx-auto">
                                      <img class="img-fluid" src="data:image/jpeg;base64,{{ base64_encode($photo->photo) }}" alt="" width="100%" class="m-0">
                                    </div>
                                    <div class="col-md-12 m-3">
                                      <p class="mt-1 fw-bold fs-5">
                                            {{$photo->username}}
                                            <span class="fw-lighter text-muted fs-6 me-1">{{$photo->caption}}</span>
                                      </p>
                                      @if(!empty($photo->tags))
                                          @foreach ($photo->tags as $tag)
                                            <button type="button" class="btn btn-sm btn-secondary mb-2 disabled">{{ $tag->name }}</button>
                                          @endforeach
                                      @endif
                                      <div class="d-grid gap-1 d-md-flex mt-3">
                                        <a href="{{url('login')}}" class="btn btn-sm btn-light"><i class="bi bi-suit-heart-fill me-1"></i> {{$likes}} Likes</a>
                                        <a href="{{url('login')}}" class="btn btn-sm btn-light"><i class="bi bi-suit-heart me-1"></i> Unlikes</a>
                                      </div>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          @endforeach
      </div>
    </div>
  </div>
  @endif
</main>
@endsection