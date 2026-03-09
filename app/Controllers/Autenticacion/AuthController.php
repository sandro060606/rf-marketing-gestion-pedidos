<?php
namespace App\Controllers\Autenticacion;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    // Muestra el formulario de login
    // Si el usuario ya tiene sesión activa, lo redirige directo a su panel
    public function login()
    {
        if (session()->get('rol')) {
            return $this->redirigirPorRol(session()->get('rol'));
        }
        return view('acceso/login');
    }

    // Recibe los datos del formulario y verifica las credenciales
    // Si son correctas guarda la sesión y redirige según el rol
    // Si son incorrectas regresa al login con un mensaje de error
    public function autenticar()
    {
        $usuario    = $this->request->getPost('usuario');
        $contrasena = $this->request->getPost('clave');

        // Verifica que los campos no estén vacíos
        if (empty($usuario) || empty($contrasena)) {
            return redirect()->to('/login')
                             ->with('error', 'Completa todos los campos.');
        }

        $modelo    = new UsuarioModel();
        $usuarioDB = $modelo->buscarPorUsuario($usuario);

        // Verifica que el usuario exista y que la contraseña sea correcta
        if (!$usuarioDB || !password_verify($contrasena, $usuarioDB['clave'])) {
            return redirect()->to('/login')
                             ->with('error', 'Usuario o contraseña incorrectos.');
        }

        // Guarda los datos del usuario en la sesión
        session()->set([
            'id'            => $usuarioDB['id'],
            'nombre'        => $usuarioDB['nombre'],
            'apellidos'     => $usuarioDB['apellidos'],
            'rol'           => $usuarioDB['rol'],
            'idarea'        => $usuarioDB['idarea'],
            'esresponsable' => $usuarioDB['esresponsable'],
        ]);

        return $this->redirigirPorRol($usuarioDB['rol']);
    }

    // Destruye la sesión activa y regresa al login
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Redirige al panel correspondiente según el rol del usuario
    private function redirigirPorRol($rol)
    {
        switch ($rol) {
            case 'Administrador':
                return redirect()->to('/admin/panel');
            case 'Empleado':
                return redirect()->to('/empleado/mis-pedidos');
            case 'Cliente':
                return redirect()->to('/cliente/mis-pedidos');
            default:
                return redirect()->to('/login');
        }
    }
}