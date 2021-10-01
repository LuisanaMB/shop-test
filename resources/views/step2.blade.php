@extends('layouts.app')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"></script>

    <script>
        $("#btn-next").click(function(event) {
            event.preventDefault();
            if (isEmpty($('#email'))) {
                alert("Vacio");
            }else{
                let email = $("#email").val();
                axios.get('/users/show/'+email)
                .then(response => {
                    let user = response.data;
                    $("#email").attr('disabled', true);
                    if (user.id){
                        $("#remembered_user").val(1);
                        $("#remembered_user_name").html(user.name);
                        $("#personal-data-div").addClass("d-none");
                        $("#btn-next-div").addClass("d-none");
                        $("#remembered_user_div").removeClass("d-none");
                    }else{
                        $("#remembered_user").val(0);
                        $("#name").val('');
                        $("#phone").val('');
                        $("#remembered_user_div").addClass("d-none");
                        $("#btn-next-div").addClass("d-none");
                        $("#personal-data-div").removeClass("d-none");
                    }
                })
                .catch(e => {
                    console.log(e);
                })
            }
        });

        $(".cancel-btn").click(function(event) {
            event.preventDefault();
            $("#email").val("");
            $("#remembered_user").val(0);
            $("#email").attr("disabled", false);
            $("#personal-data-div").addClass("d-none");
            $("#remembered_user_div").addClass("d-none");
            $("#btn-next-div").removeClass("d-none"); 
        });

        $(".continue-btn").click(function(event) {
            event.preventDefault();
            $("#step1").addClass("d-none");
            $("#step2").removeClass("d-none");
        });

        function isEmpty(el){
            return !$.trim(el.val());
        }
    </script>
@endpush

@section('content')
    <div class="row p-5" style="margin-right: 0 !important; margin-left: 0 !important;">
        <div class="col"></div>
        <div class="col-5">
            <div class="card">
                <div class="card-header text-center" style="border-bottom: solid 2px #007bff;">
                    @if ($order->status == "CREATED")
                        <img src="{{ asset('assets/images/order.png') }}" width="25%">
                        <div class="row mt-3">
                            <div class="col-12"><h5 class="card-title">Su orden ha sido creada!!</h5></div>
                            <div class="col-12"><a class="btn btn-success btn-block" href="{{ $order->payment_url }}" target="_blank">PAGAR</a></div>
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
                            <div class="col-12"><button class="btn btn-success btn-block">REINTENTAR</button></div>
                        </div>
                    @else
                        <img src="{{ asset('assets/images/pending.png') }}" width="25%">
                        <div class="row">
                            <div class="col"><h5 class="card-title">Su orden está en proceso de pago!!</h5></div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if ($order->status == "CREATED")
                        <ul class="list-group">
                            <li class="list-group-item active" aria-current="true">Datos del Comprador</li>
                            <li class="list-group-item">Correo Electrónico: <span class="font-weight-bold">{{ $order->user->email }}</span></li>
                            <li class="list-group-item">Nombre: <span class="font-weight-bold">{{ $order->user->name }}</span></li>
                            <li class="list-group-item">Teléfono: <span class="font-weight-bold">{{ $order->user->phone }}</span></li>
                            <li class="list-group-item text-center"><a href="#">Actualizar mis datos</a></li>
                        </ul>
                    @endif
                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true">Detalles de la Orden</li>
                        <li class="list-group-item">Referencia: <span class="font-weight-bold">Payment_{{ $order->id }}</span></li>
                        <li class="list-group-item">Producto: <span class="font-weight-bold">{{ $order->product->name }}</span></li>
                        <li class="list-group-item">Total: <span class="font-weight-bold">{{ $order->amount }} USD</span></li>
                        <li class="list-group-item">Fecha: <span class="font-weight-bold">{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</span></li>
                        <li class="list-group-item">Estado: <span class="font-weight-bold">{{ $order->status }}</span></li>
                        @if ($order->status == "CREATED")
                            <li class="list-group-item"><a class="btn btn-success btn-block" href="{{ $order->payment_url }}" target="_blank">PAGAR</a></li>
                        @elseif ($order->status == 'REJECTED')
                            <li class="list-group-item"><button class="btn btn-success btn-block">REINTENTAR</button></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>

    <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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
                    <button type="button" class="btn btn-primary" id="save-btn">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
@endsection