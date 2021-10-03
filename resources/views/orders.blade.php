@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
    
    <script>
        $(document).ready( function () {
            $('#ordersTable').DataTable();
        });
    </script>
    
@endpush

@section('content')
    <div class="container">
        <div class="text-center p-4">
            <h3 class="font-italic">Listado de órdenes</h3>
        </div>
        
        <div class="pb-5">
            <table class="table table-striped table-bordered table-hover" id="ordersTable">
                <thead class="thead-dark">
                    <th># Orden</th>
                    <th>Correo Comprador</th>
                    <th>Producto</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>
                                @if (!is_null($order->product_id))
                                    {{ $order->product->name }}
                                @else
                                    Dato no disponible
                                @endif
                            </td>
                            <td>{{ $order->amount }} USD</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection