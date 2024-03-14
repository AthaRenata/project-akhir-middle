<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/categories" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Categories" ><i class="bi-card-checklist fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Tambah Kategori
    </h2>

    <div class="mt-2 p-3 text-theme2 bg-theme3 rounded">
        <form action="/admin/categories" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="icon" class="form-label">Ikon</label>
                <input class="form-control @error('icon') is-invalid @enderror" type="file" name="icon" id="icon" required autofocus>
                @error('icon')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Cth. Minuman" required value="{{old('name')}}">
                @error('name')
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