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
        // Si ya hay sesión iniciada, ir al panel correspondiente
        if (session()->get('rol')) {
            return $this->redirigirPorRol(session()->get('rol'));
        }
        // Sin sesión → mostrar el formulario de login
        return view('acceso/login');
    }

    // Recibe los datos del formulario y verifica las credenciales
    // Verifica contra la BD y crea la sesión si es correcto
    // Si son correctas guarda la sesión y redirige según el rol
    // Si son incorrectas regresa al login con un mensaje de error
    public function autenticar()
    {
        $usuario = $this->request->getPost('usuario');
        $contrasena = $this->request->getPost('clave');

        // Validación: campos vacíos
        if (empty($usuario) || empty($contrasena)) {
            return redirect()->to('/login')
                ->with('error', 'Completa todos los campos.');
        }
        // Buscar Usuario en la BD
        $modelo = new UsuarioModel();
        $usuarioDB = $modelo->buscarPorUsuario($usuario);

        // Verifica que el usuario exista y que la contraseña sea correcta
        if (!$usuarioDB) {
            return redirect()->to('/login')
                ->with('error', 'Usuario o contraseña incorrectos.');
        }

        // Verificar contraseña
        if ($contrasena !== $usuarioDB['clave']) {
            return redirect()->to('/login')
                ->with('error', 'Usuario o contraseña incorrectos.');
        }

        // Buscar empresa del cliente (solo si es cliente)
        $empresa = null;
        if ($usuarioDB['rol'] === 'cliente') {
            $empresaModel = new \App\Models\EmpresaModel();
            $empresa = $empresaModel->buscarPorUsuario($usuarioDB['id']);
        }
        
        // Guarda los datos del usuario en la sesión
        session()->set([
            'autenticado' => true,               // Flag que usa el filtro
            'id' => $usuarioDB['id'],
            'nombre' => $usuarioDB['nombre'],
            'apellidos' => $usuarioDB['apellidos'],
            'correo' => $usuarioDB['correo'],
            'usuario' => $usuarioDB['usuario'],
            'rol' => $usuarioDB['rol'],   // administrador / empleado / responsable / cliente
            'idarea' => $usuarioDB['idarea'],
            'area' => $usuarioDB['area'],  // nombre del área (para mostrar en el panel)
            'esresponsable' => $usuarioDB['esresponsable'],
            'empresa' => $empresa['nombreempresa'] ?? null,
        ]);
        //Redirigir por Rol
        return $this->redirigirPorRol($usuarioDB['rol']);
    }

    // Destruye la sesión activa y regresa al login
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // PRIVADO: Redirige según el rol del usuario
    private function redirigirPorRol($rol)
    {
        switch ($rol) {
            case 'administrador':
                return redirect()->to('/admin/panel');
            case 'responsable':
                return redirect()->to('/responsable/pedidos-area');
            case 'empleado':
                return redirect()->to('/empleado/mis-pedidos');
            case 'cliente':
                return redirect()->to('/cliente/mis-pedidos');
            default:
                return redirect()->to('/login');
        }
    }
}