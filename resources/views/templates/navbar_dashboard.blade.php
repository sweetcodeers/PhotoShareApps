<div class="container-fluid">
  <header class="d-flex fixed-top flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-white">
    <div class="d-flex align-items-start col-md-4">
      <a href="{{route('photo.list')}}" class="ms-4 mb-2 mb-md-0 text-dark text-decoration-none">
        <i class="bi bi-camera2 fs-3"></i>
        <span class="fs-5 ms-1">Gallery</span>
      </a>
  
      
    </div>

    <div class="col-md-4 text-end me-3">
      <div class="d-flex justify-content-end">
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            @if (!empty($user->photo_profile))
              <img class="img-fluid border-0 icon-profil" src="data:image/jpeg;base64,{{ base64_encode($user->photo_profile) }}">
            @else
              <img class="img-fluid border-0 icon-profil" src="{{ asset('images/people.png') }}">
            @endif
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li>
              <a class="dropdown-item" href="{{url('profil')}}">
                <small>Profile</small>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{url('logout')}}">
                <small>Logout</small>
              </a>
            </li>
          </ul>
        </div>

        
      </div>
    </div>
  </header>
</div>


