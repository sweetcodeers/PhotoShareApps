@extends('layouts.master_dashboard')
@section('content')
<main class="photo">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 fw-bold">Create new a photo</h4>
            </div>
            <div class="card-body">
                <form action="{{route('photo.store')}}" class="row" method="POST" enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="form-group mb-3">
                      <label for="caption" class="form-label">Caption</label>
                      <textarea class="form-control form-control-sm @error('caption') is-invalid @enderror" id="caption" name="caption" style="height: 100px">{{old('caption')}}</textarea>
                      <!--Notif error-->
                      @if($errors->has('caption'))
                        <small class="text-danger">{{ $errors->first('caption') }}</small>
                      @endif
                    </div>
                    <div class="form-group mb-3">
                      <label for="photo" class="form-label">Photo</label>
                      <input type="file" class="form-control form-control-sm @error('photo') is-invalid @enderror" id="photo" name="photo" aria-label="Upload">
                      <!--Notif error-->
                      @if($errors->has('photo'))
                        <small class="text-danger">{{ $errors->first('photo') }}</small>
                      @endif
                    </div>
                    <div class="form-group mb-5">
                      <label for="tag" class="form-label">Tag</label>
                      <input type="text" class="form-control form-control-sm @error('tag') is-invalid @enderror" id="tag" name="tag" value="{{old('tag')}}"/>
                      <!--Notif error-->
                      @if($errors->has('tag'))
                        <small class="text-danger">{{ $errors->first('tag') }}</small>
                      @endif
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="submit" class="btn btn-dark btn-sm">Submit</button>
                        <a href="{{route('photo.list')}}" class="btn btn-outline-dark">Back</a>
                    </div>
                  </form>
            </div>
        </div>
    </div>
</main>
@endsection
