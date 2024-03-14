<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/dashboard" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Dashboard"><i class="bi-speedometer2 fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Pesanan
    </h2>

    <div class="d-flex justify-content-end my-3">
        <a href="/admin/orders/create" class="btn btn-primary text-decoration-none">
            <i class="bi-plus-circle px-1"></i>Tambah Pesanan</a>
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
        @if ($orders->isEmpty())
          <h4 class="text-body-secondary">Belum ada order yang ditambahkan</h4>
      @else
      <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Pembayaran</th>
                <th>Detail</th>
                </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
                <tr>
                    <td>{{$orders->firstItem() + $loop->index}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->customer->username}} {{$order->customer->full_name}}</td>
                    <td>Rp{{number_format($order->payment,'2',',','.')}}</td>
                    <td>
                        <a href="/admin/orders/{{$order->id}}" class="btn btn-info"><i class="bi-eye"></i></a>
                        <form action="/admin/orders/{{$order->id}}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Yakin batalkan pesanan ini?')"><i class="bi-slash-circle"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
            @endforeach
      </table>
      @endif
      <div class="mt-4 d-flex justify-content-end">
        {{$orders->links()}}
      </div>
    </div>
</div>

    </div>
</x-web.layout>

<script>
    $(document).ready(function() {
        localStorage.clear();
    });
</script>