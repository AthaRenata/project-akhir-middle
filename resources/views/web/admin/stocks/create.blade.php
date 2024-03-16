<x-web.layout>
    <div role="main" class="col-sm bg-theme2">

<div class="container py-5">
    <h2 class="text-theme3">
        <a href="/admin/stocks" class="text-theme3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Stocks" ><i class="bi-box2-heart-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Tambah Stok
    </h2>

    <div class="mt-2 p-3 text-theme2 bg-theme3 rounded">
        <form action="/admin/stocks" method="POST" enctype="multipart/form-data">
            @csrf               
            <div class="mb-3 row row-cols-1 row-cols-md-3">
                <div class="col">
                <label for="product_id" class="form-label">Produk</label>
                <div class="d-flex gap-1">
                <select name="product_id" id="product_id" class="form-select" autofocus>
                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary" id="add-stock-btn"><i class="bi-plus"></i></button>
                </div>
                </div>
                <div class="col">
                <label for="cost" class="form-label">Total Harga Beli</label>
                    <input type="number" class="form-control @error('cost') is-invalid @enderror" name="cost" id="cost" placeholder="Cth. 15999" required value="{{old('cost')}}">
                    @error('cost')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col">
                <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" required value="{{old('date',date('Y-m-d'))}}">
                    @error('date')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 w-100" id="stock-list">
                <div id="stock-item-template" style="display: none">
                    <div class="stock-item row mb-3">
                        <div class="col">
                            <input type="hidden" class="id">
                            <label class="name form-label"></label>
                            <div class="d-flex gap-1">
                                <input type="number" class="quantity form-control @error('quantity') is-invalid @enderror" placeholder="Jumlah Pcs" value="{{old('quantity')}}">
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

              <div>
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
        </form>
    </div>

</div>

</div>
</x-web.layout>

<script>
    $(document).ready(function() {
    var index = 0;
    var removedOptions = []; 
    
    $('#add-stock-btn').click(function() {
    var productId = $('#product_id').val();
    var productName = $('#product_id option:selected').text();

    if (productId) {
        var $template = $('#stock-item-template').clone(); 
        $template.removeAttr('id').removeAttr('style');
        $template.find('.name').text(productName); 
        $template.find('.id').attr('name', 'products['+index+'][id]').val(productId);
        $template.find('.quantity').attr('name', 'products['+index+'][quantity]').prop('required',true);

        $('#stock-list').append($template);
    }

    removedOptions.push($('#product_id option[value="' + productId + '"]').detach());

    index++;
    });

    $(document).on('click', '.cancel-stock-btn', function() {
        var id = $(this).closest('.stock-item').find('.id').val();
        $(this).closest('.stock-item').remove();

        var index = removedOptions.findIndex(function(option) {
            return option.val().includes(id);
        });

            removedOption = removedOptions.splice(index, 1)[0];;
            $('#product_id').append(removedOption);   
        
    });

});

</script>