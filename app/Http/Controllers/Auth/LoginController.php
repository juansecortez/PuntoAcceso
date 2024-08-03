<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Determine where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Obtiene al usuario autenticado
        $user = Auth::user();

        // Asume que el rol está almacenado en una propiedad llamada 'role'
        // y que el rol específico se llama 'admin' (cambia según sea necesario)
        if ($user->isMember()) {
            return '/uso_puerta';
        }

        // Redirigir al home por defecto
        return '/home';
    }
}
