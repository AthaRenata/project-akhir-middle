<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/orders" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pesanan" ><i class="bi-table fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Detail Pesanan
    </h2>
    
    <div class="p-5 text-theme2 bg-theme3 rounded">
        <div class="row row-cols-1 row-cols-lg-2">
                <h4 class="col text-theme2 mb-3">
                    <div class="col">Dipesan Tanggal :</div>
                    <strong class="col">{{$order->created_at}}</strong></h4>
                <h4 class="col text-theme2 mb-5">
                    <div class="col">Oleh : </div>
                    <strong class="col">{{$order->full_name}}</strong>
                <span class="text-body-secondary">({{$order->username}})</span>
                </h4>
            </div>
        <h4 class="text-theme2 mb-3">Daftar Pesanan</h4>

        <ul class="list-group list-group-flush">
            @foreach ($details as $detail)
                <li class="list-group-item d-flex justify-content-between">
                    <div class="row row-cols-1 row-cols-lg-2 w-100">
                        <span class="col">{{$loop->iteration}}. {{$detail->product_name}} <span class="badge rounded-pill text-bg-secondary">{{$detail->category_name}}</span></span>
                        <span class="col text-body-secondary">Rp{{number_format($detail->price,'2',',','.')}}</span>
                    </div>
                    <div>{{$detail->quantity}}</div>
                </li>
            @endforeach
            <li class="list-group-item list-group-item-danger d-flex justify-content-between">
                    <span>Total Pembayaran</span>
                    <strong>Rp{{number_format($order->payment,'2',',','.')}}</strong>
            </li>
        </ul>

    

    <div class="mb-3 w-100" id="stock-list">
        <div id="stock-item-template" style="display: none">
            <div class="stock-item row mb-3">
                <div class="col">
                    <input type="hidden" class="id">
                    <input type="hidden" class="price">
                    <label class="name form-label"></label>
                    <div class="d-flex gap-1">
                        <div class="input-group">
                        <input min="1" type="number" class="quantity form-control @error('quantity') is-invalid @enderror" placeholder="Jumlah Pcs" value="{{old('quantity')}}">
                        <span class="input-group-text">Rp</span>
                        <span class="input-group-text itemPrice"></span>
                        </div>
                        <button type="button" class="btn btn-danger cancel-stock-btn"><i class="bi-dash"></i></button>
                    </div>
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>  
        </div>   
</div>
</div>
</div>

</div>
</x-web.layout>