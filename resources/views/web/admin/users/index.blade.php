<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/dashboard" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Dashboard"><i class="bi-speedometer2 fs-1"></i></a>
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
        <form action="/admin/users/{{auth()->user()->id}}" method="POST">
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

    <div class="d-flex justify-content-between mt-5 mb-3">
        <h4 class="text-theme2">DATA PENGGUNA</h4>
        <a href="/admin/users/create" class="btn btn-primary text-decoration-none">
            <i class="bi-plus-circle px-1"></i>Tambah Pengguna</a>
    </div> 

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-info">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>E-Mail</th>
                    <th>Hak Akses</th>
                    <th>Aksi</th>
                    </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if ($user->role==1)
                                Admin
                            @else
                                Staf
                            @endif
                        </td>
                        <td>
                            <a href="/admin/users/{{$user->id}}/edit" class="btn btn-warning"><i class="bi-pencil"></i></a>
                            <form action="/admin/users/{{$user->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('Yakin akan hapus data ini?')"><i class="bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                @endforeach
          </table>
          <div class="mt-4 d-flex justify-content-end">
            {{$users->links()}}
          </div>
    </div>
</div>

    </div>
</x-web.layout>