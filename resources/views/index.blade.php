@extends('layouts.app')

@section('content')
    <div class="row p-5">
        <div class="col"></div>
        <div class="col-5">
            <div class="card">
                <img src="{{ asset('assets/images/producto.png') }}" alt="Producto 1" height="300">
                <div class="card-body">
                    <div class="row">
                        <div class="col"><h5 class="card-title">Producto #1</h5></div>
                        <div class="col text-right"><h4 class="card-title">$50 USD</h4></div>
                    </div>
                   
                    <form>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Tu correo aquí">
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre y Apellido</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Tu nombre aquí...">
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="phone" class="form-control" name="phone" id="phone" placeholder="Tu teléfono aquí...">
                        </div>
                        <div class="form-group text-right">
                            <a href="#" class="btn btn-primary">Continuar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection