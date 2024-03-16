<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/products" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Product"><i class="bi-box2-heart-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Stok
    </h2>

    <div class="d-flex justify-content-end my-3">
        <a href="/admin/stocks/create" class="btn btn-primary text-decoration-none">
            <i class="bi-plus-circle px-1"></i>Tambah Stok</a>
    </div> 
    
    @if (session()->has('success'))
    <div class="alert alert-success w-100 mt-3 d-flex align-items-center justify-content-between" role="alert">
      <div>
        {!! session('success') !!}
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="table-responsive">
        @if ($stocks->isEmpty())
          <h4 class="text-body-secondary">Belum ada stok yang ditambahkan</h4>
      @else
        <table class="table table-striped">
            @foreach ($stocks as $stock)
            <thead class="table-success">
                <tr>
                    <td>Tanggal : <strong>{{$stock->date}}</strong></td>
                    <td>Total : <strong> Rp{{number_format($stock->cost,'2',',','.')}} / {{$stock->products->sum('pivot.quantity')}} Pcs </strong></td>
                    <td>
                    <a href="/admin/stocks/{{$stock->date}}/edit" class="btn btn-warning"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Ubah Data"><i class="bi-pencil"></i></a>
                    <form action="/admin/stocks/{{$stock->date}}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Yakin akan hapus data ini?')"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Hapus Data"><i class="bi-trash"></i></button>
                    </form>
                    </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">
                            <table class="table mb-0">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Jumlah Stok</th>
                                </tr>
                                @foreach ($stock->products as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->pivot->quantity}} Pcs</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </tbody>
                @endforeach
          </table>
          @endif
          <div class="mt-4 d-flex justify-content-end">
            {{$stocks->links()}}
          </div>
    </div>
</div>

    </div>
</x-web.layout>