@extends('layouts.app')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"></script>

    <script>
        $("#btn-next").click(function(event) {
            event.preventDefault();
            var forma = document.getElementById("email");
            if(forma.checkValidity()){
                $("#error-email").addClass("d-none");

                let email = $("#email").val();
                axios.get('/users/show/'+email)
                .then(response => {
                    let user = response.data;
                    $("#hidden_email").val($("#email").val());
                    $("#email").attr('disabled', true);
                    if (user.id){
                        $("#remembered_user").val(user.id);
                        $("#remembered_user_name").html(user.name);
                        $("#name").attr('required', false);
                        $("#phone").attr('required', false);
                        $("#personal-data-div").addClass("d-none");
                        $("#btn-next-div").addClass("d-none");
                        $("#remembered_user_div").removeClass("d-none");
                    }else{
                        $("#remembered_user").val(0);
                        $("#name").val('');
                        $("#phone").val('');
                        $("#name").attr('required', true);
                        $("#phone").attr('required', true);
                        $("#remembered_user_div").addClass("d-none");
                        $("#btn-next-div").addClass("d-none");
                        $("#personal-data-div").removeClass("d-none");
                    }
                })
                .catch(e => {
                    console.log(e);
                })
            }else{
                $("#error-email").removeClass("d-none");
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

        $("#store-form").on("submit", function(){
            $(".btn-submit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...');
        });
    </script>
@endpush

@section('content')
    <div class="row p-5" style="margin-right: 0 !important; margin-left: 0 !important;">
        <div class="col"></div>
        <div class="col-xl-5 col-lg-6">
            <div class="card">
                <div class="card-header text-center" style="border-bottom: solid 2px #007bff;">
                    <img src="{{ asset('assets/images/product.png') }}" width="35%" alt="Producto 1"> 
                    <div class="row mt-2">
                        <div class="col text-left"><h5 class="card-title">{{ $product->name }}</h5></div>
                        <div class="col text-right"><h5 class="card-title">${{ $product->price }} USD</h5></div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST" id="store-form">
                        @csrf
                        <input type="hidden" name="remembered_user" id="remembered_user" value="0">
                        <input type="hidden" name="hidden_email" id="hidden_email">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="form-group text-center">
                            <label for="email">Ingresa tu correo electrónico</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" autofocus required>
                            </div>
                            <small class="text-danger d-none" id="error-email"><i class="fas fa-exclamation-circle"></i> Debe introducir un correo válido</small>
                        </div>
                       
                        <div class="form-row d-none" id="personal-data-div">
                            <div class="form-group col-md-12">
                                Por favor, completa tus datos para continuar
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Nombre y apellido</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                                <small class="text-danger d-none" id="error-name">Debe introducir su nombre</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Teléfono</label>
                                <input type="phone" class="form-control" name="phone" id="phone" required>
                                <small class="text-danger d-none" id="error-phone">Debe introducir su número de teléfono</small>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn btn-danger btn-block cancel-btn">Cancelar</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary btn-block btn-submit">Continuar</button>
                            </div>
                        </div>
                        <div class="form-row d-none" id="remembered_user_div">
                            <div class="form-group col-md-12 text-center">
                                <h2><i class="far fa-hand-paper text-success"></i></h2>
                                <h5>Bienvenido de vuelta <span class="font-weight-bold" id="remembered_user_name"></span>!!</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn btn-danger btn-block cancel-btn">Cancelar</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary btn-block btn-submit">Continuar</button>
                            </div>
                        </div>
                        <div class="form-row" id="btn-next-div">
                            <div class="form-group col-md-6">
                                <a href="{{ route('index') }}" class="btn btn-danger btn-block">Cambiar Producto</a>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary btn-block" id="btn-next">Continuar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection