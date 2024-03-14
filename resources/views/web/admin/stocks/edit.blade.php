<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/stocks" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Stocks" ><i class="bi-box2-heart-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Ubah Stok / {{$stock->date}}
    </h2>

    <div class="mt-2 p-3 text-theme2 bg-theme3 rounded">
        <form action="/admin/stocks/{{$stock->date}}" method="POST" enctype="multipart/form-data">
            @method('put')
            @csrf               
            <div class="mb-3">
                <label for="cost" class="form-label">Total Harga Beli</label>
                    <input type="number" class="form-control @error('cost') is-invalid @enderror" name="cost" id="cost" placeholder="Cth. 15999" required value="{{old('cost',$stock->cost)}}">
                    @error('cost')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
            </div>

            <div class="mb-3 w-100" id="stock-list">
                <div id="stock-item-template" style="display: none">
                    <div class="stock-item row mb-3">
                        <div class="col">
                            <input type="hidden" class="id">
                            <label class="name form-label"></label>
                            <div class="d-flex gap-1">
                                <input min="1" type="number" class="quantity form-control @error('quantity') is-invalid @enderror" placeholder="Jumlah Pcs" value="{{old('quantity')}}">
                            </div>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div> 
                </div>
                @foreach($stock->products as $product)
                    <div class="stock-item row mb-3">
                        <div class="col">
                            <input name="products[{{$loop->iteration}}][id]" type="hidden" class="id" value="{{$product->id}}">
                            <label class="name form-label">{{$product->name}}</label>
                            <div class="d-flex gap-1">
                                <input min="1" type="number" name="products[{{$loop->iteration}}][quantity]" class="quantity form-control @error('quantity') is-invalid @enderror" placeholder="Jumlah Pcs" value="{{old('quantity',$product->pivot->quantity)}}">
                            </div>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div> 
                 @endforeach
            </div>
            <div>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>

        </form>
    </div>
    </div>
</div>

</div>
</x-web.layout>