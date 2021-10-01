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
                    $("#hidden_email").val($("#email").val());
                    $("#email").attr('disabled', true);
                    if (user.id){
                        $("#remembered_user").val(user.id);
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
            $("#hidden_email").val();
            $("#remembered_user").val(0);
            $("#email").attr("disabled", false);
            $("#personal-data-div").addClass("d-none");
            $("#remembered_user_div").addClass("d-none");
            $("#btn-next-div").removeClass("d-none"); 
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
                    <img src="{{ asset('assets/images/producto.png') }}" width="25%" alt="Producto 1"> 
                    <div class="row">
                        <div class="col"><h5 class="card-title">Producto #1</h5></div>
                        <div class="col text-right"><h4 class="card-title">$50 USD</h4></div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="remembered_user" id="remembered_user" value="0">
                        <input type="hidden" name="hidden_email" id="hidden_email">
                        <div class="form-group text-center">
                            <label for="email">Ingresa tu correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" autocomplete="off" autofocus>
                        </div>
                        <div class="form-row d-none" id="personal-data-div">
                            <div class="form-group col-md-12">
                                Por favor, completa tus datos para continuar
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Nombre y apellido</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Teléfono</label>
                                <input type="phone" class="form-control" name="phone" id="phone">
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn btn-danger btn-block cancel-btn">Cancelar</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">Continuar</button>
                            </div>
                        </div>
                        <div class="form-row d-none" id="remembered_user_div">
                            <div class="form-group col-md-12">
                                Bienvenido de vuelta <span class="font-weight-bold" id="remembered_user_name"></span>!!
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn btn-danger btn-block cancel-btn">Cancelar</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">Continuar</button>
                            </div>
                        </div>
                        <div class="form-group" id="btn-next-div">
                            <button class="btn btn-primary btn-block" id="btn-next">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection