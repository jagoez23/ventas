@extends('template')

@section('title', 'marcas')

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
        <h1 class="mt-4 text-center">Marcas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Marcas</li>
        </ol>

        <div class="mb-4">
            <a href="{{ route('marcas.create') }}"><button type="button" class="btn btn-primary">Añadir nueva
                    marca</button></a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Marcas
            </div>
            {{-- {{$marcas}} --}}
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped fs-6">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcas as $marca)
                            <tr>
                                <td>
                                    {{ $marca->caracteristica->nombre }}
                                </td>
                                <td>
                                    {{ $marca->caracteristica->descripcion }}
                                </td>
                                <td>
                                    @if ($marca->caracteristica->estado == 1)
                                        <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                        <form action="{{ route('marcas.edit', ['marca' => $marca]) }}" method="get">
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>

                                        @if ($marca->caracteristica->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $marca->id }}">Eliminar</button>
                                        @else
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $marca->id }}">Restaurar</button>
                                        @endif

                                        <div>
                                            <!------Eliminar marca---->
                                            @can('eliminar-marca')
                                                @if ($marca->caracteristica->estado == 1)
                                                    <button title="Eliminar" data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal-{{ $marca->id }}"
                                                        class="btn btn-datatable btn-icon btn-transparent-dark">
                                                        <svg class="svg-inline--fa fa-trash-can" aria-hidden="true"
                                                            focusable="false" data-prefix="far" data-icon="trash-can"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 448 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <button title="Restaurar" data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal-{{ $marca->id }}"
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
                            <div class="modal fade" id="confirmModal-{{ $marca->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $marca->caracteristica->estado == 1 ? '¿Seguro que quieres eliminar la marca?' : '¿Seguro que quieres restaurar la marca?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <form action="{{ route('marcas.destroy', ['marca' => $marca->id]) }}"
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
