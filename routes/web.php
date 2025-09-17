    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\ContactoController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\UsuarioEstudianteController;

    /*
    |--------------------------------------------------------------------------
    | Rutas públicas
    |--------------------------------------------------------------------------
    */

    // Página principal pública
    Route::get('/', function () {
        return view('contacto'); // Página de contacto visible para todos
    })->name('home');

    // Rutas de Contacto
    Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
    Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

    // Otras páginas públicas del navbar
    Route::view('/somos', 'somos')->name('somos');
    Route::view('/mision', 'mision')->name('mision');
    Route::view('/vision', 'vision')->name('vision');
    Route::view('/soluciones', 'soluciones')->name('soluciones');
    Route::view('/politica', 'politica')->name('politica');
    Route::view('/terminos', 'terminos')->name('terminos');
    Route::view('/faq', 'faq')->name('faq');

    // Rutas de Login y Registro públicas
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('registro');
    Route::post('/registro', [AuthController::class, 'register'])->name('registro.submit');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot-password.submit');

    /*
    |--------------------------------------------------------------------------
    | Rutas protegidas (solo usuarios autenticados)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        // Dashboard principal después de login
        Route::view('/index2', 'index2')->name('index2');

        // Sección Usuarios
        Route::view('/personal', 'secciones.personal')->name('personal');
        Route::view('/estudiantes', 'secciones.estudiantes')->name('estudiantes');
        Route::view('/docentes', 'secciones.docentes')->name('docentes');

        // Sección Administrativos
        Route::view('/oficinas', 'secciones.oficinas')->name('oficinas'); // si existe
        Route::view('/vigilantes', 'secciones.vigilantes')->name('vigilantes');
        Route::view('/enfermeria', 'secciones.enfermeria')->name('enfermeria');

        // Sección Servicios
        Route::view('/parqueadero', 'secciones.parqueadero')->name('parqueadero');
        Route::view('/visitantes', 'secciones.visitantes')->name('visitantes');
        Route::view('/acudientes', 'secciones.acudientes')->name('acudientes');

        // Guardar registro de estudiante
        Route::post('/usuario/registro', [UsuarioEstudianteController::class, 'store'])->name('usuario.store');
        // Consultar estudiante
        Route::post('/usuario/consulta', [UsuarioEstudianteController::class, 'consulta'])->name('usuario.consulta');
    });
