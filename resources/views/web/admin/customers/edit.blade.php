<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/customers" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pelanggan" ><i class="bi-people-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Ubah Pelanggan
    </h2>

    <div class="mt-2 p-3 text-theme2 bg-theme3 rounded">
        <form action="/admin/customers/{{$customer->username}}" method="POST">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username" value="{{old('username',$customer->username)}}" placeholder="Cth. user-1231231" required autofocus>
                @error('username')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" id="full_name" placeholder="Cth. Nama User" required value="{{old('full_name',$customer->full_name)}}">
                @error('full_name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telepon</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Cth. 08123123123" required value="{{old('phone',$customer->phone)}}">
                @error('phone')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Cth. name@example.com" required value="{{old('email',$customer->email)}}">
                @error('email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
              </div>
              <div>
                <button class="btn btn-success">Simpan</button>
              </div>
        </form>
    </div>

</div>

</div>
</x-web.layout>