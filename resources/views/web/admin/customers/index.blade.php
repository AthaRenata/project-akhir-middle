<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/dashboard" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Dashboard"><i class="bi-speedometer2 fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Pelanggan
    </h2>

    <div class="d-flex justify-content-end my-3">
        <a href="/admin/customers/create" class="btn btn-primary text-decoration-none">
            <i class="bi-plus-circle px-1"></i>Tambah Pelanggan</a>
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
        @if ($customers->isEmpty())
          <h4 class="text-body-secondary">Belum ada pelanggan yang ditambahkan</h4>
      @else
        <table class="table table-hover">
            <thead class="table-info">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Telepon</th>
                    <th>E-Mail</th>
                    <th>Aksi</th>
                    </tr>
            </thead>
            <tbody>
            @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customers->firstItem() + $loop->index}}</td>
                        <td>{{$customer->username}}</td>
                        <td>{{$customer->full_name}}</td>
                        <td>{{$customer->phone}}</td>
                        <td>{{$customer->email}}</td>
                        <td>
                            <a href="/admin/customers/{{$customer->username}}/edit" class="btn btn-warning"  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Ubah Data"><i class="bi-pencil"></i></a>
                            <form action="/admin/customers/{{$customer->username}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('Yakin akan hapus data ini?')" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Hapus Data" ><i class="bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                @endforeach
          </table>
          @endif
          <div class="mt-4 d-flex justify-content-end">
            {{$customers->links()}}
          </div>
    </div>
</div>

    </div>
</x-web.layout>