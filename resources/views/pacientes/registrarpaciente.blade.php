@extends('layouts.plantilla')

@section('contenido')
    <h1>Registrar Pacientes</h1>


    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Nombre Completo</label>
            <input type="nombre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese el nombre">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>

       <!--FECHA-->
        <div class="row">
            <div class="col-sm-6 col-lg-5 mb-3 mb-sm-0">
                <div data-coreui-locale="en-US" data-coreui-toggle="date-picker"></div>
            </div>
            <div class="col-sm-6 col-lg-5">
                <div data-coreui-date="2023/03/15" data-coreui-locale="en-US" data-coreui-toggle="date-picker"></div>
            </div>
        </div>

        <!--GENERO-->
        <h3>Genero</h3>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Femenino
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                Masculino
            </label>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Numero de identidad</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Numero de identidad">
        </div>

        <div data-mdb-input-init class="form-outline mb-3" style="width: 100%; max-width: 22rem">
            <input type="text" id="phone" class="form-control" data-mdb-input-mask-init data-mdb-input-mask="+48 999-999-999" />
            <label class="form-label" for="phone">Numero de Telefono con codigo de pais</label>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>

    </form>
