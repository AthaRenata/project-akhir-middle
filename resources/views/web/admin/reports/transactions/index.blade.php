<x-web.layout>
    <div role="main" class="col-sm bg-theme3">

<div class="container py-5">
    <h2 class="text-theme2">
        <a href="/admin/products" class="text-theme2" data-bs-toggle="tooltip" data-bs-original-title="Product"><i class="bi-box2-heart-fill fs-1"></i></a>
        <i class="bi-caret-right-fill fs-1"></i>
        Laporan Transaksi
    </h2>

<div class="p-4 my-3 rounded bg-theme4">
    <form method="POST" class="d-inline">
        @csrf
    <div class="mb-3 row">
<div class="col mb-sm-3 mb-md-0 pilihan">
    @isset($fromDate)

    <div class="input-group">
    <span class="input-group-text">Dari</span>
    <input type="date" class="form-control @error('fromDate') is-invalid @enderror" name="fromDate" value="{{old('fromDate',$fromDate)}}" required>
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

@isset($transactions)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-info">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pendapatan</th>
                    <th>Pengeluaran</th>
                    <th>Laba</th>
                    <th>Rugi</th>
                    </tr>
            </thead>
            <tbody>
                
            @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$transaction->date}}</td>
                        <td>Rp{{number_format($transaction->income,2,',','.')}}</td>
                        <td>Rp{{number_format($transaction->expenditure,2,',','.')}}</td>
                        <td>Rp{{number_format($transaction->profit,2,',','.')}}</td>
                        <td>Rp{{number_format($transaction->loss,2,',','.')}}</td>
                    </tr>
                </tbody>
                @endforeach
                <tr>
                    <th colspan="2" class="text-center">Total</th>
                    <td>Rp{{number_format($transactions->sum('income'),2,',','.')}}</td>
                    <td>Rp{{number_format($transactions->sum('expenditure'),2,',','.')}}</td>
                    <td>Rp{{number_format($transactions->sum('profit'),2,',','.')}}</td>
                    <td>Rp{{number_format($transactions->sum('loss'),2,',','.')}}</td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        @if ($transactions->sum('profit')+$transactions->sum('loss') > 0)
                            Laba
                        @elseif ($transactions->sum('profit')+$transactions->sum('loss') < 0)
                            Rugi
                        @else
                            Impas
                        @endif
                    </th>
                    <td colspan="4">Rp{{number_format($transactions->sum('profit')+$transactions->sum('loss'),2,',','.')}}</td>
                </tr>
            </table>
        </div>
@endisset 
</div>


</div>
    </div>
</x-web.layout>