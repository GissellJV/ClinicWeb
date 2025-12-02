<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginEmpleado;
use Illuminate\Support\Carbon;

class EmpleadoController extends Controller
{
    public function crear()
    {
        if (!session('cargo') || strtolower(session('cargo')) != 'recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $cargos = ['Recepcionista', 'Doctor', 'Enfermero', 'Gerente', 'Administrativo'];
        $departamentos = ['Recepción', 'Medicina General', 'Pediatría', 'Cirugía', 'Administración'];

        return view('empleados.crear', compact('cargos', 'departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'numero_identidad' => 'required|string|size:13|regex:/^\d{4}\d{4}\d{5}$/|unique:empleados,numero_identidad',
            'cargo' => 'required|string',
            'departamento' => 'required|string',
            'fecha_ingreso' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $edadIngreso = Carbon::parse($value)->age;
                    if ($edadIngreso > 80) {
                        $fail('La edad no puede ser mayor a 80 años.');
                    }
                }
            ],
            'telefono' => 'required|string|size:8|regex:/^[2389]\d{7}$/',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/',
            'genero' => 'required|in:Femenino,Masculino',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres',
            'apellido.required' => 'El apellido es obligatorio',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios',
            'apellido.max' => 'El apellido no puede tener más de 50 caracteres',
            'cargo.required' => 'El cargo es obligatorio',
            'departamento.required' => 'El departamento es obligatorio',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida',
            'numero_identidad.required' => 'El número de identidad es obligatorio',
            'numero_identidad.regex' => 'El formato del número de identidad no es válido',
            'numero_identidad.size' => 'El número de identidad debe tener 13 dígitos',
            'telefono.required' => 'El número de teléfono es obligatorio',
            'telefono.regex' => 'El número de teléfono no es válido',
            'telefono.size' => 'El número de teléfono debe tener 8 dígitos',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.regex' => 'La contraseña debe incluir mayúsculas, minúsculas y números',
            'genero.required' => 'El género es obligatorio',
            'foto.image' => 'El archivo debe ser debe ser formato jpeg, png o jpg',
            'foto.required' => 'Debe seleccionar una foto',
            'foto.mimes' => 'La foto debe ser formato jpeg, png o jpg',
            'foto.max' => 'La foto no puede superar los 2MB'
        ]);

        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'numero_identidad' => $request->numero_identidad,
            'cargo' => $request->cargo,
            'departamento' => $request->departamento,
            'fecha_ingreso' => $request->fecha_ingreso,
            'genero' => $request->genero,
        ]);

        // Guardar la foto si existe
        if ($request->hasFile('foto')) {
            $foto = file_get_contents($request->file('foto')->getRealPath());
            $empleado->foto = $foto;
            $empleado->save();
        }

        // Crear el login asociado
        $empleado->loginEmpleado()->create([
            'empleado_nombre' => $request->nombre,
            'empleado_apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('empleados.lista')->with('success', 'Empleado registrado exitosamente.');
    }
    public function edit($id)
    {
        if (!session('cargo') || strtolower(session('cargo')) != 'recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $empleado = Empleado::findOrFail($id);

        // Ya no necesitas pasar cargos y departamentos porque estarán bloqueados
        return view('empleados.editar', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellido' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'telefono' => 'required|string|size:8|regex:/^[2389]\d{7}$/',
            'password' => 'nullable|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres',
            'apellido.required' => 'El apellido es obligatorio',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios',
            'apellido.max' => 'El apellido no puede tener más de 50 caracteres',
            'telefono.required' => 'El número de teléfono es obligatorio',
            'telefono.regex' => 'El número de teléfono no es válido',
            'telefono.size' => 'El número de teléfono debe tener 8 dígitos',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.regex' => 'La contraseña debe incluir mayúsculas, minúsculas y números',
            'foto.image' => 'El archivo debe ser una imagen',
            'foto.mimes' => 'La foto debe ser formato jpeg, png o jpg',
            'foto.max' => 'La foto no puede superar los 2MB',
        ]);

        $empleado = Empleado::findOrFail($id);

        // Solo actualizar nombre y apellido
        $empleado->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
        ]);

        // Actualizar foto solo si se subió una nueva
        if ($request->hasFile('foto')) {
            $foto = file_get_contents($request->file('foto')->getRealPath());
            $empleado->foto = $foto;
            $empleado->save();
        }

        // Preparar datos para actualizar login
        $loginData = [
            'empleado_nombre' => $request->nombre,
            'empleado_apellido' => $request->apellido,
            'telefono' => $request->telefono,
        ];

        // Actualizar contraseña solo si se proporcionó una nueva
        if ($request->filled('password')) {
            $loginData['password'] = bcrypt($request->password);
        }

        // Actualizar login asociado
        $empleado->loginEmpleado()->update($loginData);

        return redirect()->route('empleados.lista')->with('success', 'Empleado actualizado con exito');
    }

    public function destroy($id)
    {
        if (!session('cargo') || session('cargo') != 'Recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Enfermero');
        }

        $empleado = Empleado::findOrFail($id);


        if ($empleado->loginEmpleado) {
            $empleado->loginEmpleado->delete();
        }

        // Ahora sí, eliminar el empleado
        $empleado->delete();

        return redirect()->route('empleados.lista')
            ->with('success', 'Empleado eliminado con exito.');
    }



    public function lista()
    {
        if (!session('cargo') || strtolower(session('cargo')) != 'recepcionista') {
            return redirect()->route('inicioSesion')
                ->with('error', 'Debes iniciar sesión como Recepcionista');
        }

        $empleados = Empleado::orderBy('created_at', 'desc')->get();
        return view('empleados.lista', compact('empleados'));
    }


    public function mostrarFoto($id)
    {
        $empleado = Empleado::findOrFail($id);

        if ($empleado->foto) {
            return response($empleado->foto)
                ->header('Content-Type', 'image/jpeg');
        }

    }

    public function subirFoto(Request $request)
    {
        try {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'foto.required' => 'Debes seleccionar una foto',
                'foto.image' => 'El archivo debe ser una imagen',
                'foto.mimes' => 'Solo se permiten archivos JPG, JPEG o PNG',
                'foto.max' => 'La foto no debe superar los 2MB'
            ]);

            $empleadoId = session('empleado_id');

            if (!$empleadoId) {
                return redirect()->back()->with('error', 'No se encontró la sesión del empleado');
            }

            $empleado = Empleado::findOrFail($empleadoId);

            if ($request->hasFile('foto')) {
                $foto = file_get_contents($request->file('foto')->getRealPath());
                $empleado->foto = $foto;
                $empleado->save();

                return redirect()->back()->with('success', 'Foto actualizada con exito');
            }

            return redirect()->back()->with('error', 'No se recibió ningún archivo');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

}
