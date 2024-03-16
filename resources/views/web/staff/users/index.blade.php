<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="min-vh-100 container py-5">
    <h2 class="text-theme2">
        <a href="/home" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Beranda"><i class="bi-house-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Profil
    </h2>
    
    @if (session()->has('success'))
    <div class="alert alert-success w-100 mt-3 d-flex align-items-center justify-content-between" role="alert">
      <div>
        {!! session('success') !!}
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="mt-2 p-3 text-theme2 rounded">
        <form action="/users/{{auth()->user()->id}}" method="POST">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Cth. Nama User" required value="{{old('name',auth()->user()->name)}}">
                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Cth. name@example.com" required value="{{old('email',auth()->user()->email)}}">
                @error('email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Kata Sandi">
                @error('password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
              <div>
                <button class="btn btn-success" type="submit">Perbarui Profil</button>
              </div>
        </form>
    </div>
</div>

    </div>
</x-web.layout>