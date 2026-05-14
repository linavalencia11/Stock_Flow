<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario as User;
use App\Models\Rol;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'contacto' => ['nullable', 'string', 'max:255'],
        ]);
        $rol = Rol::where('nombre', 'Solicitante')->firstOrFail();//como utilizamos uuid, no podemos asumir que el id del rol solicitante es siempre el mismo, por lo que buscamos el rol por su nombre
        $user = User::create([
            'id' => $request->id,//aca porque se supone que el id es el numero de cedula
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contacto' => $request->contacto,
            'rol_id' => $rol->id,
            'activo' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
