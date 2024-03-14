<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/products" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Products" ><i class="bi-box2-heart-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Tambah Produk
    </h2>

    <div class="mt-2 p-3 text-theme2 bg-theme3 rounded">
        <form action="/admin/products" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" id="category_id" class="form-select" autofocus required>
                    @if ($categories->isEmpty())
                        <option value="">Tanpa Kategori</option>
                    @endif
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
              </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Foto</label>
                <input class="form-control" type="file" name="photo" id="photo">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Cth. Almond Brown Sugar Croissant" required value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="Cth. Croissant manis dengan atasan kacang almond dan gula cokelat" required>{{old('description')}}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
             </div>
             <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" step="any" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="Cth. 15999" required value="{{old('price')}}">
                @error('price')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                </div>
              </div>
              <div>
                <button class="btn btn-success">Simpan</button>
              </div>
        </form>
    </div>

</div>

</div>
</x-web.layout>