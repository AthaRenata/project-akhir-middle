<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/dashboard" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Dashboard"><i class="bi-speedometer2 fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Kategori
    </h2>

    <div class="d-flex justify-content-end my-3">
        <a href="/admin/categories/create" class="btn btn-primary text-decoration-none">
          <i class="bi-plus-circle px-1"></i>Tambah Kategori</a>
    </div> 

    @if (session()->has('success'))
    <div class="alert alert-success w-100 mt-3 d-flex align-items-center justify-content-between" role="alert">
      <div>
        {!! session('success') !!}
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="row mt-2">
      @if ($categories->isEmpty())
          <h4 class="text-body-secondary">Belum ada kategori yang ditambahkan</h4>
      @else
        @foreach ($categories as $category)
            <div class="col-md-3 mb-3">

                <div class="card h-100 mb-3">
                    <div class="row g-0">
                      <div class="col-lg-4 p-3">
                        <img src="{{asset($category->icon)}}" width="50" height="50" alt="{{$category->name}}"/>
                      </div>
                      <div class="col-lg-8">
                        <div class="card-body">
                          <h5 class="card-title">{{$category->name}}</h5>
                        <form action="/admin/categories/{{$category->name}}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                        <button class="btn btn-danger" onclick="return confirm('Yakin akan hapus data ini?')"><i class="bi-trash"></i></button>
                        </form>
                        <a href="/admin/categories/{{$category->name}}/edit" class="btn btn-warning"><i class="bi-pencil"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            @endforeach
          @endif
          <div class="mt-4 d-flex justify-content-end">
            {{$categories->links()}}
          </div>
        </div>

</div>

    </div>
</x-web.layout>