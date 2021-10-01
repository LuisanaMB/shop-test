@extends('layouts.app')

@section('content')
    <div class="row p-5" style="margin-right: 0 !important; margin-left: 0 !important;">
        <div class="col-12 pb-4">
            <h3 class="font-italic">Elija el producto que desea comprar...</h3>
        </div>
        @foreach($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 pt-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <img src="{{ asset('assets/images/product.png') }}" class="card-img-top" alt="...">
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Precio: <b>{{ $product->price }} USD</b></p>
                        <div class="text-center">
                            <a href="{{ route('orders.create', $product->id) }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Comprar</a>
                        </div>
                    </div>
                </div>                
            </div>
        @endforeach
    </div>
@endsection