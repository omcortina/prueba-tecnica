<title>Empleados</title>
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
                    {!! Form::open(array('method' => 'POST', 'id' => 'frmEdit')) !!}
                    <h4 class="card-title"><b>Formulario de registro</b></h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Nombre completo (*)</label>
                                <input type="text" class="form-control" value="{{ $employee->nombre }}" name="nombre" id="nombre">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Correo electrónico (*)</label>
                                <input type="text" class="form-control" value="{{ $employee->nombre }}" name="email" id="email">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Sexo (*)</label>
                                <select name="sexo" id="sexo" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @if ($employee->sexo ==  "M")
                                        <option selected value="1">Masculino</option>
                                        <option value="2">Femenino</option>
                                    @else
                                        <option value="1">Masculino</option>
                                        <option selected value="2">Femenino</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Area (*)</label>
                                <select name="area_id" id="area_id" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach ($areas as $item)
                                        @if ($employee->area_id == $item->id)
                                            <option selected value="{{ $item->id }}">{{ $item->nombre }}</option>    
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="form-check form-check-inline mt-5">
                                    <input class="form-check-input" name="boletin" type="checkbox" id="boletin">
                                    <label class="form-check-label" for="boletin">
                                        Deseo recibir boletín informativo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Descripción (*)</label>
                                <textarea type="text" rows="3" cols="50" class="form-control" name="descripcion" id="descripcion">{{ $employee->descripcion }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label><b>Roles (*)</b></label>
                                @foreach ($roles as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" name="roles[]" value="{{ $item->id }}" type="checkbox" value="" id="rol_{{ $item->id }}">
                                        <label class="form-check-label" for="rol_{{ $item->id }}">{{ $item->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <button onclick="edit()" style="width: 100%;" type="button" class="btn btn-primary">Registrar</button>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var roles = []
        $( document ).ready(function() {
            @foreach($roles as $item)
                roles.push({
                    id: {{ $item->id }},
                    name: '{{ $item->nombre }}'
                })

                @foreach($employee->roles as $rol)
                    @if($rol->rol_id == $item->id)
                        $("#rol_"+{{ $item->id }}).prop('checked', true)
                    @endif
                @endforeach
            @endforeach

            @if($employee->boletin == 1)
                $("#boletin").prop("checked", true)
            @endif
        })

        function edit(){
            let nombre = $("#nombre").val()
            let email = $("#email").val()
            let sexo = $("#sexo").val()
            let area_id = $("#area_id").val()
            let boletin = $("#boletin").val()
            let descripcion = $("#descripcion").val()
            if(nombre == "" || email == "" || sexo == "" || area_id == "" || descripcion == ""){
                tata.error('Prueba Técnica', 'Todos los campos son obligatorios', {
                    duration: 2000
                })
                return false
            }

            let contador = 0
            this.roles.forEach((item) => {
                if($('#rol_'+item.id)[0].checked){
                    contador++
                }
            })

            if(contador == 0){
                tata.error('Prueba Técnica', 'No hay roles seleccionados', {
                    duration: 2000
                })
                return false
            }

            $("#frmEdit").submit()
        }
    </script>
@endsection
