<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/products" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Product"><i class="bi-box2-heart-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Laporan Produk Paling Sering Dibeli
    </h2>

    <div class="p-4 my-3 rounded bg-theme4">
        <form method="POST" class="d-inline">
            @csrf
        <div class="mb-3 row">
    <div class="col mb-sm-3 mb-md-0 pilihan">
        @isset($fromDate)
        
        <div class="input-group">
        <span class="input-group-text">Dari</span>
        <input type="date" class="form-control  @error('fromDate') is-invalid @enderror" name="fromDate" value="{{old('fromDate',$fromDate)}}" required>
        <span class="input-group-text">Sampai</span>
        <input type="date" class="form-control @error('toDate') is-invalid @enderror" name="toDate" value="{{old('fromDate',$toDate)}}" required>
        @error('fromDate')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        @error('toDate')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        </div>

        @else
        <div class="input-group">
            <span class="input-group-text">Dari</span>
            <input type="date" class="form-control" name="fromDate" required>
            <span class="input-group-text">Sampai</span>
            <input type="date" class="form-control" name="toDate" required>
            </div>
            
        @endisset
    </div>
    
    <button class="col-md-1 btn btn-primary">Lihat</button>
    </div>
    </form>
    
    @isset($grosses)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-info">
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Banyak Dibeli</th>
                        </tr>
                </thead>
                <tbody>
                    
                @foreach ($grosses as $gross)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$gross->name}}</td>
                            <td>{{$gross->category}}</td>
                            <td>{{$gross->price}}</td>
                            <td>{{$gross->total_qty}}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
    @endisset 
    </div>

</div>
    </div>
</x-web.layout>