@extends('template')

@section('title', 'Productos')

@push('css-datatable')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

@if (session('success'))
 <script>

    let message = "{{ session('success') }}"

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: "success",
        title: message
      });
 </script>
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Productos</li>
    </ol>

    <div class="mb-4">
        <a href="{{route('productos.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo producto</button></a>
    </div>
</div>

<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de Productos
        </div>
</div>
<div class="card-body">
    <table id="datatablesSimple" class="table table-striped fs-6">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
                <th>Acciones</th>
                <th>Acciones</th>
                <th>Acciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>                         


@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush