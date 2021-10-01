@extends('layouts.app')

@push('scripts')
    <script>
        $(".retry-btn").click(function(event) {
            event.preventDefault();
            $("#retry-form").submit();
        });

        $(".payment-btn").click(function() {
            $(".payment-btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espere...');
        });

        $("#save-btn").click(function() {
            $("#save-btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espere...');
        });
    </script>
@endpush

@section('content')
    <div class="row p-5" style="margin-right: 0 !important; margin-left: 0 !important;">
        <div class="col"></div>
        <div class="col-xl-5 col-lg-6">
            @if (Session::has('msj'))
                <div class="alert alert-success">
                    <i class="far fa-check-circle"></i> {{ Session::get('msj') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header text-center" style="border-bottom: solid 2px #007bff;">
                    @if ($order->status == "CREATED")
                        <img src="{{ asset('assets/images/order.png') }}" width="25%">
                        <div class="row mt-3">
                            <div class="col-12"><h5 class="card-title">Su orden ha sido creada!!</h5></div>
                            <div class="col-12"><a class="btn btn-success btn-block payment-btn" href="{{ $order->payment_url }}"><i class="far fa-credit-card"></i> PAGAR</a></div>
                        </div>
                    @elseif ($order->status == "PAYED")
                        <img src="{{ asset('assets/images/check.png') }}" width="25%">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Su orden ha sido completada!!</h5></div>
                        </div>
                    @elseif ($order->status == 'REJECTED')
                        <img src="{{ asset('assets/images/error.png') }}" width="25%">
                        <div class="row">
                            <div class="col-12"><h5 class="card-title">Su orden ha sido rechazada!!</h5></div>
                            <div class="col-12"><button class="btn btn-success btn-block retry-btn payment-btn"><i class="fas fa-redo-alt"></i> REINTENTAR</button></div>
                        </div>
                    @else
                        <img src="{{ asset('assets/images/pending.png') }}" width="25%">
                        <div class="row">
                            <div class="col-12"><h5 class="card-title">Su orden está en proceso de pago!!</h5></div>
                            <div class="col-12"><a class="btn btn-success btn-block payment-btn" href="{{ $order->payment_url }}"><i class="far fa-question-circle"></i> CONSULTAR EN PLACETOPAY</a></div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if ($order->status == "CREATED")
                        <ul class="list-group">
                            <li class="list-group-item active" aria-current="true"><i class="fas fa-user-tag"></i> Datos del Comprador</li>
                            <li class="list-group-item">Correo Electrónico: <span class="font-weight-bold">{{ $order->user->email }}</span></li>
                            <li class="list-group-item">Nombre: <span class="font-weight-bold">{{ $order->user->name }}</span></li>
                            <li class="list-group-item">Teléfono: <span class="font-weight-bold">{{ $order->user->phone }}</span></li>
                            <li class="list-group-item text-center"><a href="#personal-data-modal" data-toggle="modal">Actualizar mis datos</a></li>
                        </ul>
                    @endif
                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true"><i class="fas fa-clipboard-list"></i> Detalles de la Orden</li>
                        <li class="list-group-item">Referencia: <span class="font-weight-bold">payment_{{ $order->id }}</span></li>
                        <li class="list-group-item">Producto: <span class="font-weight-bold">{{ $order->product->name }}</span></li>
                        <li class="list-group-item">Total: <span class="font-weight-bold">{{ $order->amount }} USD</span></li>
                        <li class="list-group-item">Fecha: <span class="font-weight-bold">{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</span></li>
                        <li class="list-group-item">Estado: <span class="font-weight-bold">{{ $order->status }}</span></li>
                        @if ($order->status == "CREATED")
                            <li class="list-group-item"><a class="btn btn-success btn-block payment-btn" href="{{ $order->payment_url }}"><i class="far fa-credit-card"></i> PAGAR</a></li>
                        @elseif ($order->status == 'REJECTED')
                            <li class="list-group-item"><button class="btn btn-success btn-block payment-btn retry-btn"><i class="fas fa-redo-alt"></i> REINTENTAR</button></li>
                        @elseif ($order->status == "PENDING")
                            <li class="list-group-item"><a class="btn btn-success btn-block payment-btn" href="{{ $order->payment_url }}"><i class="far fa-question-circle"></i> CONSULTAR EN PLACETOPAY</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="retry-form">
        @csrf
        <input type="hidden" name="remembered_user" value="{{ $order->user_id }}">
        <input type="hidden" name="product_id" value="{{ $order->product_id }}">
    </form>

    <div class="modal fade" id="personal-data-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.update', $order->user_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="modal-body">    
                        <div class="form-group">
                            <label for="name">Nombre y Apellido</label>
                            <input type="text" class="form-control" name="name" id="name" value={{ $order->user->name }}>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="phone" class="form-control" name="phone" id="phone" value={{ $order->user->phone }}>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="save-btn">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection