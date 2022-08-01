<title>Usuarios</title>
@extends('layouts.index')

@section('breadcumb')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Empleados</h3>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if (session('message_success_employee_create'))
                        <div id="msg" class="alert alert-success" >
                            <li>{{session('message_success_employee_create')}}</li>
                        </div>
                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                        </script>
                    @endif

                    @if (session('message_success_employee_edit'))
                        <div id="msg" class="alert alert-success" >
                            <li>{{session('message_success_employee_edit')}}</li>
                        </div>
                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                        </script>
                    @endif

                    <h4 class="card-title">Listado de empleados</h4>
                    <button class="btn btn-primary mt-3 mb-3" onclick="location.href='{{ route('create') }}'">Nuevo</button>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Sexo</th>
                                    <th>Area</th>
                                    <th>Boletín</th>
                                    <th>...</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                    <tr>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->sexo == 'M' ? "Masculino" : "Femenino" }}</td>
                                        <td>{{ $item->area->nombre }}</td>
                                        <td>{{ $item->boletin == 1 ? "Si" : "No" }}</td>
                                        <td>
                                            <a href="{{ route('edit', $item->id) }}" title="Editar">
                                                <i class="mdi mdi-24px mdi-account-edit"></i>
                                            </a>
                                            <a href="#" onclick="deleteUser('{{ route('delete', $item->id) }}')" title="Eliminar">
                                                <i class="mdi mdi-24px mdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function deleteUser(route){
            Swal.fire({
                title: '¿Desea eliminar este empleado?',
                text: "No se podrá recuperar la información!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get(route, (response) => {
                        if(!response.error){
                            Swal.fire(
                                'Eliminado!',
                                response.message,
                                'success'
                            ).then((result) => {
                                if(result.isConfirmed) location.reload()
                            })
                        }
                    })
                    
                }
            })
        }
    </script>
@endsection
