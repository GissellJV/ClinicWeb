@extends('layouts.plantillaAdmin')
<link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

@section('contenido')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:whitesmoke;
        }
        .text-info-emphasis {

            font-weight: bold;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
        }


    </style>

    <br> <br> <br> <br>
    <h1 class="text-center text-info-emphasis">Publicidad</h1>
   <div class="formulario">

       <div class="form-container">

           {{-- Mensaje de éxito --}}
           @if(session('success'))
               <div style="background:#d4edda; padding:10px; border-radius:5px; margin-bottom:15px;">
                   {{ session('success') }}
               </div>
           @endif

           {{-- Formulario --}}
           <form action="{{ isset($promocion) ? route('promociones.actualizar',$promocion->id) : route('promociones.store') }}"
                 method="POST" enctype="multipart/form-data">

               @csrf

               @if(isset($promocion))
                   @method('PUT')
               @endif

               <div>
                   <label>Título</label>
                   <input type="text" name="titulo" class="form-control"
                          value="{{ old('titulo', $promocion->titulo ?? '') }}">

                   @error('titulo')
                   <div class="text-danger mt-1">{{ $message }}</div>
                   @enderror

               </div>

               <div>
                   <label class="mt-3">Descripción</label>
                   <textarea name="descripcion" class="form-control">{{ old('descripcion', $promocion->descripcion ?? '') }}</textarea>

                   @error('descripcion')
                   <div class="text-danger mt-1">{{ $message }}</div>
                   @enderror
               </div>


               <div>
                   <label class="mt-3">Imagen</label>
                   <input type="file" name="imagen" class="form-control" accept="image/*">
                   <small class="text-muted">Formatos: JPG, PNG (Máx. 2MB)</small>
                   @if(isset($promocion) && $promocion->imagen)
                       <div style="margin-top:10px">
                           <img src="data:image/jpeg;base64,{{ base64_encode($promocion->imagen) }}" width="120">
                       </div>
                   @endif
               </div>

               <div style="margin-top: 20px" class="button-group">
                   <button class="btn-register">
                       {{ isset($promocion) ? 'Actualizar' : 'Guardar' }}
                   </button>

                   <button type="button" class="btn-cancel"
                           onclick="window.location.href='/#publi'">
                       Cancelar
                   </button>
               </div>

           </form>
       </div>
   </div>
@endsection

