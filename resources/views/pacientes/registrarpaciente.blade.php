@extends('layouts.plantilla')

@section('contenido')
    <br><br><br>

    <h1 style="text-align: center">Regístrate para Agendar tu Cita</h1>

    <div class="d-flex justify-content-center align-items-center vh-100">
    <form class="p-4 border rounded" style="max-width: 600px; width: 200%;">

        <!--NOMBRE COMPLETO-->
        <div class="row">
            <label for="exampleInputEmail1">Nombre Completo</label>
            <div class="col-md-6">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
        </div>
            </div>

            <div class="col-md-6">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos">
        </div>
            </div>
        </div>

       <!--FECHA-->
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" >
                </div>
            </div>
        </div>

        <!--GENERO-->
        <div class="mb-3">
            <label for="exampleInputEmail1">Genero</label>
        <div class="row">

            <div class="col-md-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Femenino
            </label>
        </div>
            </div>
            <div class="col-md-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
                Masculino
            </label>
        </div>
            </div>
        </div>
        </div>

        <!--Numero de identidad-->
        <div class="form-group mb-3" style="width: 100%; max-width: 22rem">
            <label for="exampleInputPassword1">Numero de identidad</label>
            <input type="text" class="form-control" id="numeroIdentidad">

        </div>

        <!--Numero de Telefono con codigo de pais-->
        <div data-mdb-input-init class="form-outline mb-3" style="width: 100%; max-width: 22rem">
            <label class="form-label" for="phone">Numero de Telefono</label>
            <input type="text" id="phone" class="form-control" data-mdb-input-mask-init data-mdb-input-mask="+48 999-999-999" />
        </div>

        <div class="form-group mb-3" style="width: 100%; max-width: 22rem">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" >
            <small class="form-text text-muted">(Mínimo 8 caracteres)</small>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
        <button type="reset" class="btn btn-danger">Cancelar</button>

    </form>
    </div>
