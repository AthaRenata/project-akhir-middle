<x-web.layout>

    <div role="main" class="col-sm bg-theme3">
        
        <div class="container py-5">
    <div class="p-4 rounded bg-theme2">

            <h2 class="text-theme3">
                <a href="/admin/home" class="text-theme3" data-bs-toggle="tooltip" data-bs-original-title="Beranda"><i class="bi-house-fill fs-1"></i></a>
                <i class="bi-caret-right-fill fs-1"></i>
                Dashboard
            </h2>

    <div class="p-4 mt-4 rounded bg-theme4">
            <div class=" row row-cols-1 row-cols-md-3 g-5">
                <div class="col">
                <div class="card bg-theme1 shadow-lg text-theme3 h-100">
                    <div class="card-header"><h5>Total Produk</h5></div>
                    <div class="card-body d-flex w-100">
                        <h1 class="card-text flex-grow-1 text-center">{{$totalProducts}}</h1>
                        <i class="bi-box2-heart-fill fs-1 flex-grow-1 text-center"></i>
                    </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-theme1 shadow-lg text-theme3 h-100">
                        <div class="card-header"><h5>Total Transaksi Hari Ini</h5></div>
                        <div class="card-body d-flex w-100">
                            <h1 class="card-text flex-grow-1 text-center">{{$orderToday}}</h1>
                            <i class="bi-calendar-day fs-1 flex-grow-1 text-center"></i>
                        </div>
                      </div>
                </div>
                <div class="col">
                    <div class="card bg-theme1 shadow-lg text-theme3 h-100">
                        <div class="card-header"><h5>Total Transaksi Bulan Ini</h5></div>
                        <div class="card-body d-flex w-100">
                            <h1 class="card-text flex-grow-1 text-center">{{$orderMonth}}</h1>
                            <i class="bi-calendar-month fs-1 flex-grow-1 text-center"></i>
                        </div>
                      </div>
                </div>


            </div>
            <div class="mt-4 row row-cols-1 row-cols-md-2 g-5">

                <div class="col">
                    <div class="card bg-theme1 shadow-lg text-theme3 h-100">
                        <div class="card-header"><h5>Total Pendapatan Hari Ini</h5></div>
                        <div class="card-body d-flex w-100">
                            <h1 class="card-text flex-grow-1 text-center">Rp{{number_format($incomeToday,'2',',','.')}}</h1>
                            <i class="bi-calendar-day-fill fs-1 flex-grow-1 text-center"></i>
                        </div>
                      </div>
                </div>
                <div class="col">
                    <div class="card bg-theme1 shadow-lg text-theme3 h-100">
                        <div class="card-header"><h5>Total Pendapatan Bulan Ini</h5></div>
                        <div class="card-body d-flex w-100">
                            <h1 class="card-text flex-grow-1 text-center">Rp{{number_format($incomeMonth,'2',',','.')}}</h1>
                            <i class="bi-calendar-month-fill fs-1 flex-grow-1 text-center"></i>
                        </div>
                      </div>
                </div>
              </div>
            </div>
    </div>
        </div>
    </div>

</x-web.layout>