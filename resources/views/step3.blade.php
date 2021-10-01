@extends('layouts.app')

@section('content')
    <div class="row p-5" style="margin-right: 0 !important; margin-left: 0 !important;">
        <div class="col"></div>
        <div class="col-5">
            <div class="card">
                <div class="card-header text-center" style="border-bottom: solid 2px #007bff;">
                    @if ($order->status == "PAYED")
                        <img src="{{ asset('assets/images/check.png') }}" width="50%">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Su orden ha sido completada!!</h5></div>
                        </div>
                    @elseif ($order->status == 'REJECTED')
                        <img src="{{ asset('assets/images/error.png') }}" width="50%">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Su orden ha sido rechazada!!</h5></div>
                            <div class="col text-right"><button class="btn btn-success">Reintentar</button></div>
                        </div>
                    @else
                        <img src="{{ asset('assets/images/pending.png') }}" width="50%">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Su orden está en proceso de pago!!</h5></div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true">Detalles de la Orden</li>
                        <li class="list-group-item">Referencia: <span class="font-weight-bold">Payment_{{ $order->id }}</span></li>
                        <li class="list-group-item">Producto: <span class="font-weight-bold">{{ $order->product->name }}</span></li>
                        <li class="list-group-item">Total: <span class="font-weight-bold">{{ $order->amount }} USD</span></li>
                        <li class="list-group-item">Estado: <span class="font-weight-bold">{{ $order->status }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection