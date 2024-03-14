<x-web.layout>
    <div role="main" class="col-sm">
    <header id="header">
        <div class="row min-vh-100">
        <div class="col-md-6" style="background-image: url('{{asset('assets/images/heroimg.jpg')}}'); " >
        </div>
        <div class="col-md-6 bg-theme4 d-flex align-items-center justify-content-center">
                <div class="py-5">
                    <h4 class="text-danger-emphasis p-0 m-0">WELCOME, {{auth()->user()->name}}</h4>
                    <h1 class="font-allison text-theme1 p-0 m-0" style="font-size:250px">Reisto</h1>
                    <p class="text-theme2 p-0 m-0 fs-3">Find your favorite menus at Reisto</p>
                    {{-- <p class="text-theme2">Temukan hidangan favorit Anda di Reisto</p> --}}
                    <div class="d-flex gap-2 my-2">
                    <a href="#" class="btn btn-warning mr-3">Take Order</a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                    </div>
                </div>
        </div>
    </div>
    </div>
    
    </x-web.layout>
    