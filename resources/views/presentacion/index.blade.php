@extends('template')

@section('title', 'presentaciones')


@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
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
    <h1 class="mt-4 text-center">Presentaciones</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Presentaciones</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('presentaciones.create') }}"><button type="button" class="btn btn-primary">Crear nueva
                presentación</button></a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Presentaciones
        </div>
        {{-- {{$presentaciones}} --}}
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped fs-6 text-center">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presentacione as $presentacion)
                    <tr>
                        <td>
                            {{ $presentacion->caracteristica->nombre }}
                        </td>
                        <td>
                            {{ $presentacion->caracteristica->descripcion }}
                        </td>
                        <td>
                            @if ($presentacion->caracteristica->estado == 1)
                            <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                            @else
                            <span class="fw-bolder p-1 rounded bg-danger text-white">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                <form action="{{ route('presentaciones.edit', ['presentacione' => $presentacion]) }}"
                                    method="get">
                                    <button type="submit" class="btn btn-warning rounded">Editar</button>
                                </form>

                                @if ($presentacion->caracteristica->estado == 1)
                                <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal-{{ $presentacion->id }}">Inactivar</button>
                                @else
                                <button type="button" class="btn btn-success rounded" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal-{{ $presentacion->id }}">Activar</button>
                                @endif

                                <div>
                                    <!------Inactivar presentacion---->
                                    @can('inactivar-presentacion')
                                    @if ($presentacion->caracteristica->estado == 1)
                                    <button title="Inactivar" data-bs-toggle="modal"
                                        data-bs-target="#confirmModal-{{ $presentacion->id }}"
                                        class="btn btn-datatable btn-icon btn-transparent-dark">

                                    </button>
                                    @else
                                    <button title="Activar" data-bs-toggle="modal"
                                        data-bs-target="#confirmModal-{{ $presentacion->id }}"
                                        class="btn btn-datatable btn-icon btn-transparent-dark">
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                    @endif
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal-{{ $presentacion->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $presentacion->caracteristica->estado == 1 ? '¿Seguro que quieres inactivar la
                                    presentación?' : '¿Seguro que quieres activar la presentación?' }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <form
                                        action="{{ route('presentaciones.destroy', ['presentacione' => $presentacion->id]) }}"
                                        method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush