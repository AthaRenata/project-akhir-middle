<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/users" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pengguna" ><i class="bi-people-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Ubah Pengguna
    </h2>

    <div class="mt-2 p-3 text-theme2 bg-theme3 rounded">
        <form action="/admin/users/{{$user->id}}" method="POST">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Cth. Nama Pengguna" value="{{old('name',$user->name)}}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Cth. name@example.com" value="{{old('email',$user->email)}}" required>
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
              <div class="mb-3">
                <label for="role" class="form-label">Hak Akses</label>
                <select name="role" id="role" class="form-select" autofocus required>
                    @if($user->role==1)
                        <option value="1" selected>Admin</option>
                        <option value="2">Staf</option>
                    @else
                        <option value="1">Admin</option>
                        <option value="2" selected>Staf</option>
                    @endif
                </select>
              </div>
              <div>
                <button class="btn btn-success">Simpan</button>
              </div>
        </form>
    </div>

</div>

</div>
</x-web.layout>