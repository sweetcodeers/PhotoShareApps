@extends('layouts.master_dashboard')
@section('content')
<main class="photo">
    <div class="container">
        <div class="card">
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success mb-2">
                        <small class="text-success">{!! Session::get('success') !!}</small>
                    </div>
                @elseif (Session::has('warning'))
                <div class="alert alert-warning mb-2">
                    <small>{!! Session::get('warning') !!}</small>
                </div>
                @endif
                @if (isset($photo) && is_object($photo))
                <form action="{{route('photo.update', $photo->id)}}" class="row p-3" method="POST" enctype="multipart/form-data" role="form">
                    @csrf
                    @method('PUT')
                    <div class="col-md-4">
                        @if (!empty($photo->photo))
                            <img class="img-fluid border-0 rounded" src="data:image/jpeg;base64,{{ base64_encode($photo->photo) }}">
                        @else
                            <img class="img-fluid" width="180px" src="{{ asset('images/people.png') }}">
                        @endif
                        <div class="form-group mb-3 mt-3">
                            <label for="photo" class="form-label mt-2">Edit Photo</label>
                            <input type="file" class="form-control form-control-sm @error('photo') is-invalid @enderror" id="photo" name="photo" aria-label="Upload">
                            <!--Notif error-->
                            @if($errors->has('photo'))
                                <small class="text-danger">{{ $errors->first('photo') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8 mt-3">
                        <div class="row">
                            <div class="form-group col-12 mb-4">
                                <label for="caption" class="form-label">Caption</label>
                                <textarea class="form-control form-control-sm @error('caption') is-invalid @enderror" id="caption" name="caption" style="height: 100px">{!! old('caption', $photo->caption) !!}</textarea>
                                <!--Notif error-->
                                @if($errors->has('caption'))
                                  <small class="text-danger">{{ $errors->first('caption') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="tag" class="form-label">Tag</label>
                                <input type="text" class="form-control form-control-sm @error('tag') is-invalid @enderror" id="tag" name="tag" value="{!! old('tag', $photo->tag) !!}"/>
                                <input type="hidden" name="tag_id" id="tag_id" value="{{old('tag_id', $photo->tag_id)}}">
                                <!--Notif error-->
                                @if($errors->has('tag'))
                                  <small class="text-danger">{{ $errors->first('tag') }}</small>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control form-control-sm" id="author" name="author" value="{!! old('author', $photo->username) !!}" readonly/>
                            </div>
                            <div class="form-group col-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="text" class="form-control form-control-sm" id="date" name="date" value="{!! \Carbon\Carbon::parse(old('date', $photo->created_at))->formatLocalized('%d %b %Y %H:%M') !!}" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12 mt-3 mb-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-success btn-sm">Update Photo</button>
                        <a href="{{url('profil')}}" class="btn btn-outline-secondary">Back</a>
                    </div>
                </form>
                @endif
            </div>
        </div>

        
    </div>
</main>
@endsection