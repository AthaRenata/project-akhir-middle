<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/orders" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Pesanan" ><i class="bi-table fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Tambah Pesanan
    </h2>

    <div class="my-5 bg-theme3 rounded p-5 shadow-lg">

    <div class="w-100 my-2 overflow-auto bg-theme1 rounded shadow-md" style="white-space: nowrap;">
        <div class="row d-inline">
        <form action="/admin/orders/create">
          <a href="/admin/orders/create"><span class="badge p-3 mx-1 rounded-pill text-bg-secondary">Semua Kategori</span></a>
          @foreach ($categories as $category)
              <button name="category" value="{{$category->name}}" class="mx-1 btn btn-{{$colorArray[$loop->iteration%count($colorArray)]}}"><img src="{{asset($category->icon)}}" alt="icon" width="30" height="30">{{$category->name}}</button>
          @endforeach
        </form>
    </div>
        </div>

        <div class="row">
            <div class="col">
              <form action="/admin/orders/create">
                <div class="input-group mt-3">
                  <input type="text" class="form-control" name="search" placeholder="Cari Nama Produk">
                  <button class="btn btn-danger" type="submit">Cari</button>
                </div>
              </form>
            </div>
          </div>

          @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 my-3">
          @forelse ($products as $product)
          <div class="col">
            <div class="card h-100 bg-theme1 text-theme3 shadow-md">
                <label for="{{$product->id}}">
                <div class="card-header">
                    @if ($product->stock == 0) 
                    <h4 class="text-white">Stok tidak tersedia</h4>
                    @else
                    <span class="text-theme3"><i class="bi-cart-plus-fill fs-3"><input type="checkbox" class="form-check-input" name="order" id="{{$product->id}}" value="{{$product->name}}"
                        @if (!empty($orders))
                    @foreach ($orders as $order)
                        @if ($order->name == $product->name )
                            checked disabled
                        @endif
                    @endforeach
                    @endif
                    ></i>
                    </span>
                    <input type="hidden" class="stock" value="{{$product->stock}}">
                    <input type="hidden" class="price" value="{{$product->price}}">
                    <input type="hidden" class="category_name" value="{{ $product->category ? $product->category->name : "Tidak Dikategorikan" }}">
                    @endif
                </div>
                <img src="{{asset($product->photo)}}" class="card-img-top" alt="photo" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="{{$product->full_description}}" height="200">
                <div class="card-body">
                  <h5 class="card-title">{{$product->name}}</h5>
                  <p class="card-text">{{$product->description}}</p>
                  <div>
                    <h5 class="text-theme4 d-inline">Rp{{number_format($product->price,2,',','.')}}</h5> /
                    <p class="text-white d-inline">{{$product->stock}} Pcs</p>
                  </div>
                </div>
                </label>
              </div>
            </div>
          @empty
          <h4 class="text-body-secondary fs-4">Belum ada produk</h4>
          @endforelse
          </div>

    </div>
        
          <form action="/admin/orders" method="POST">
    <div class="p-3 text-theme2 bg-theme3 rounded sticky-bottom row row-cols-1 row-cols-md-2">
        <div class="col">
            <div>
                <div>
                    {{$products->links()}}
                </div>
                <h2 class=" text-theme">Detail Pesanan</h2>
        </div>
            @csrf
            <div>
            <div class="mb-3 row row-cols-md-2">
                <div class="col">
                <label for="customer_id" class="form-label">Pelanggan</label>
                <div class="d-flex gap-1">
                <select name="customer_id" id="customer_id" class="form-select" autofocus required>
                    @foreach ($customers as $customer)
                    @if(old($customer->id)==$product->customer_id)
                        <option value="{{$customer->id}}">{{$customer->username}} {{$customer->full_name}}</option selected>
                    @else
                        <option value="{{$customer->id}}">{{$customer->username}} {{$customer->full_name}}</option>
                    @endif
                    @endforeach
                </select>
                </div>
            </div>
            <div class="col">
                <label for="payment" class="form-label">Total Pembayaran</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                <input type="number" name="payment" id="payment" class="form-control" class="@error('payment') is-invalid @enderror" readonly>
                </div>
                @error('payment')
                    {{$message}}
                @enderror
                </div>
            </div>
                </div> 
    </div>

    <div class="col overflow-y-scroll border-start border-3 border-danger rounded-4" style="max-height: 300px">
        <h4 class="text-theme2">Daftar Pesanan
        </h4>
        
    <div class="mb-3 w-100" id="stock-list">
        <div id="stock-item-template" style="display: none">
            <div class="stock-item row mb-3">
                <div class="col">
                    <input type="hidden" class="id">
                    <input type="hidden" class="price">
                    <input type="hidden" class="product_name">
                    <input type="hidden" class="category_name">
                    <label class="name form-label"></label>
                    <div class="d-flex gap-1">
                        <div class="input-group">
                        <input min="1" type="number" class="quantity form-control" placeholder="Jumlah Pcs">
                        <span class="input-group-text itemPcs"></span>
                        <span class="input-group-text">Pcs</span>
                        <span class="input-group-text">Rp</span>
                        <span class="input-group-text itemPrice"></span>
                        </div>
                        <button type="button" class="btn btn-danger cancel-stock-btn"><i class="bi-dash"></i></button>
                    </div>
                </div>
            </div>  
        </div>   
        @if (!empty($orders))
        @foreach($orders as $order)
                    <div class="stock-item row mb-3">
                        <div class="col">
                            <input name="products[{{$loop->iteration}}][id]" type="hidden" class="id" value="{{$order->id}}">
                            <input type="hidden" name="products[{{$loop->iteration}}][price]" class="price" value="{{$order->price}}">
                            <input type="hidden" name="products[{{$loop->iteration}}][product_name]" class="product_name" value="{{$order->name}}">
                            <input type="hidden" name="products[{{$loop->iteration}}][category_name]" class="category_name" value="{{$order->category->name}}">
                            <label class="name form-label">{{$order->name}}</label>
                            <div class="d-flex gap-1">
                                <div class="input-group">
                                <input min="1" type="number" name="products[{{$loop->iteration}}][quantity]" class="quantity form-control @error('products.'.$loop->iteration.'.quantity') is-invalid @enderror" placeholder="Jumlah Pcs">
                                <span class="input-group-text itemPcs">{{$order->stock}}</span>
                                <span class="input-group-text">Pcs</span>
                                <span class="input-group-text">Rp</span>
                                <span class="input-group-text itemPrice">{{$order->price}}</span>
                                @error('products.'.$loop->iteration.'.quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                </div>
                                <button type="button" class="btn btn-danger cancel-stock-btn"><i class="bi-dash"></i></button>
                            </div>
                        </div>
                    </div> 
                 @endforeach     
                 @endif
    </div>
</div>
<div class="d-flex justify-content-between">
    <button class="btn btn-success" onclick="return confirm('Pesanan sudah benar?')">Pesan</button>
    <button id="btnRefresh" type="button" class="btn btn-info"><i class="bi-arrow-clockwise"></i></button>
  </div>
</div>
</div>
</form>

</div>
</x-web.layout>


<script>
    $(document).ready(function() {
    var index = 0;
    var totalPrice = 0;
    var storedPayment = localStorage.getItem('payment');
    var storedQuantities = localStorage.getItem('quantities');
    var storedItemPrice = localStorage.getItem('itemPrice');
    
    if (storedPayment) {
        $('#payment').val(storedPayment);
        totalPrice = storedPayment;
    }

    if(storedQuantities){
        var quantitiesArray = JSON.parse(storedQuantities);

        $('.quantity').each(function(index) {
            $(this).val(quantitiesArray[index]);
        });
    }

    if(storedItemPrice){
        var quantitiesArray = JSON.parse(storedItemPrice);

        $('.quantity').each(function(index) {
            $(this).data('itemPrice', quantitiesArray[index]);
        });
    }

        $(document).on('change', '.quantity', function(){
            var quantity = $(this).val();

            var price = $(this).closest('.stock-item').find('.col .price').val();
            var id = $(this).closest('.stock-item').find('.col .id').val();
            itemPrice = quantity * price;

            totalPrice -= $(this).data('itemPrice') || 0;
            totalPrice += itemPrice;
            $(this).data('itemPrice', itemPrice);
            
            $('#payment').val(totalPrice);

            localStorage.setItem('payment', totalPrice);

            var quantities = $('.quantity').map(function() {
                return $(this).val();
            }).get();
            
            localStorage.setItem('quantities', JSON.stringify(quantities));

            var storedItemPrice = $('.quantity').map(function() {
                return $(this).data('itemPrice');
            }).get();
            
            localStorage.setItem('itemPrice', JSON.stringify(storedItemPrice));


        });

    $('input[name="order"]').change(function(){
        if($(this).is(":checked")){

        var productId =  $(this).attr('id');
        var productName = $(this).val();
        var stock = $(this).closest('.card-header').find('.stock').val();
        var price = $(this).closest('.card-header').find('.price').val();
        var category_name = $(this).closest('.card-header').find('.category_name').val();
        var $template = $('#stock-item-template').clone(); 

        $template.removeAttr('id').removeAttr('style');
        $template.find('.name').text(productName); 
        $template.find('.itemPrice').text(price); 
        $template.find('.itemPcs').text(stock); 
        $template.find('.price').attr('name', 'products['+index+'][price]').val(price); 
        $template.find('.product_name').attr('name', 'products['+index+'][product_name]').val(productName); 
        $template.find('.category_name').attr('name', 'products['+index+'][category_name]').val(category_name); 
        $template.find('.id').attr('name', 'products['+index+'][id]').val(productId);
        $template.find('.quantity').attr({
            'name':'products['+index+'][quantity]',
            'max': parseInt(stock)
        }).prop('required',true);
            
        $('#stock-list').append($template);

        $(this).prop('disabled',true);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/orders/session',
            type: 'POST',
            dataType: 'json',
            data: {
                'name': productName,
                'type' :'create'
            },
            success: function(response) {
                console.log('Data berhasil dikirim ke server');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
        index++;
        }

    });

    $(document).on('click', '.cancel-stock-btn', function() {
        var id = $(this).closest('.stock-item').find('.id').val();
        var name = $.trim($(this).closest('.stock-item').find('.name').text());

        totalPrice -= $(this).closest('.col').find('.quantity').data('itemPrice') || 0;
        $('#payment').val(totalPrice);

        localStorage.setItem('payment', totalPrice);
        
        $(this).closest('.stock-item').remove();
        
        $('#'+id).prop('checked',false);
        $('#'+id).prop('disabled',false);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/orders/session',
            type: 'POST',
            dataType: 'json',
            data: {
                'name':name,
                'type' :'delete'
            },
            success: function(response) {
                console.log('Data berhasil dikirim ke server');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $('#btnRefresh').on('click',function(){       
        $('.stock-item').not('#stock-item-template .stock-item').remove();
        $('.form-check-input').prop('checked',false).prop('disabled',false);
        $('#payment').val(0);
        localStorage.clear();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/orders/session',
            type: 'POST',
            dataType: 'json',
            data: {
                'type' :'deleteAll'
            },
            success: function(response) {
                console.log('Data berhasil dikirim ke server');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

});

</script>