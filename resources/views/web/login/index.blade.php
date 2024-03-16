<x-web.layout>
    <div role="main" class="col-sm">
    <header id="header">
        <div class="row min-vh-100">
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center" style="background-image: url('{{asset('assets/images/heroimg.jpg')}}');  background-repeat:no-repeat; background-size:cover;" >

          
          @if (session()->has('loginError'))
          <div class="alert alert-danger w-75 mt-5 d-flex align-items-center justify-content-between" role="alert">
            <div>
              {{session('loginError')}}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          <div class="card w-75 my-5 bg-body-tertiary">
            <div class="card-body">
                  <h5 class="card-title text-center text-theme2">WELCOME TO REISTO</h5>
                  <h6 class="card-subtitle text-center mb-2 text-body-secondary">Login Here</h6>
                  <div class="card-text">

                    <form class="row g-3" method="POST" action="/" autocomplete="off">
                      @csrf
                        <div class="col-12">
                          <label for="inputEmail" class="form-label">Email</label>
                          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" autofocus required value="{{ old('email') }}">
                          @error('email')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="col-12">
                          <label for="inputPassword" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" id="inputPassword" required>
                        </div>
                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary">Log in</button>
                        </div>
                      </form>

                  </div>
                </div>
              </div>


        </div>
        <div class="col-md-6 bg-theme4 d-flex align-items-center justify-content-center">
                <div>
                    <h4 class="text-danger-emphasis p-0 m-0">OUR FANCY RESTAURANT</h4>
                    <h1 class="font-allison text-theme1 p-0 m-0" style="font-size:250px">Reisto</h1>
                    <p class="text-theme2 p-0 m-0 fs-3">Find your favorite menus at Reisto</p>
                    {{-- <p class="text-theme2">Temukan hidangan favorit Anda di Reisto</p> --}}
                </div>
        </div>
    </div>
    </div>
    
    </x-web.layout>
    