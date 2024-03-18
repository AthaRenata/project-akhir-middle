<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/dashboard" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Dashboard"><i class="bi-speedometer2 fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Produk
    </h2>
        <div class="d-flex justify-content-end gap-2">
        <a href="/admin/stocks" class="btn btn-dark text-decoration-none">
          <i class="bi-eye px-1"></i>Lihat Stok</a>
        <a href="/admin/products/create" class="btn btn-primary text-decoration-none">
          <i class="bi-plus-circle px-1"></i>Tambah Produk</a>
    </div>
    
    <div class="w-100 my-2 overflow-auto bg-theme2 rounded" style="white-space: nowrap;">
    <div class="row d-inline">
    <form action="/admin/products">
      <a href="/admin/products"><span class="badge p-3 mx-1 rounded-pill text-bg-secondary">Semua Kategori</span></a>
      @foreach ($categories as $category)
          <button name="category" value="{{$category->name}}" class="mx-1 btn btn-{{$colorArray[$loop->iteration%count($colorArray)]}}"><img src="{{asset($category->icon)}}" alt="icon" width="30" height="30">{{$category->name}}</button>
      @endforeach
    </form>
</div>
    </div>

    <div class="row">
      <div class="col">
        <form action="/admin/products">
          <div class="input-group mt-3">
            <input type="text" class="form-control" name="search" placeholder="Cari Nama Produk">
            <button class="btn btn-danger" type="submit">Cari</button>
          </div>
        </form>
      </div>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success w-100 mt-3 d-flex align-items-center justify-content-between" role="alert">
      <div>
        {!! session('success') !!}
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row row-cols-1 row-cols-md-4 g-4 mt-3">
      @forelse ($products as $product)
        <div class="col">
          <div class="card h-100">
            <img src="{{asset($product->photo)}}" class="card-img-top" alt="photo" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="{{$product->full_description}}">
            <div class="card-body">
              <h5 class="card-title">{{$product->name}}</h5>
              <p class="card-text">{{$product->description}}</p>
              <div>
                <h5 class="text-theme4 d-inline">Rp{{number_format($product->price,2,',','.')}}</h5> /
                <p class="text-body-secondary d-inline">{{$product->stock}} pcs</p>
              </div>
              <div class="mt-2 d-flex justify-content-center gap-2">
                <form action="/admin/products/{{$product->name}}" method="POST" class="d-inline">
                  @method('delete')
                  @csrf
                <button class="btn btn-danger" onclick="return confirm('Yakin akan hapus data ini?')"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Hapus Data"><i class="bi-trash"></i></button>
                </form>
                <a href="/admin/products/{{$product->name}}/edit" class="btn btn-warning"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Ubah Data"><i class="bi-pencil"></i></a>
              </div>
            </div>
          </div>
        </div>
      @empty
      <h4 class="text-body-secondary fs-4">Belum ada produk</h4>
      @endforelse
      </div>

      <div class="mt-4 d-flex justify-content-end">
        {{$products->links()}}
      </div>

</div>

    </div>
</x-web.layout>