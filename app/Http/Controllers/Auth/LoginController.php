<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Activity;
use Spatie\Permission\Models\Role;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginAdminRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

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

    public function login(LoginRequest $request)
    {
        $nick = $request->nick;
        $password = $request->password;
        $menu = [];

        if ($request->tipoken == 'token') {
            $auth_user = Auth::user();
            $apiToken = 'current';

            $user = User::where('id', $auth_user->id)->with('player')->first();

            $data = array(
                'access_token' => $apiToken,
                'user' => $user,
                'menu' => ""
            );

            return $this->successResponse($data, 200);
        } else {
            $user = User::where('nick', $nick)->first() ?? null;

            if (!$user)
                return $this->errorResponse("No existe usuario con estas credenciales", 403);

            if (!$user->status)
                return $this->errorResponse("Su cuenta se encuentra inhabiltada.", 403);

            // if (!$user->hasRole('player')) {
            //     return $this->errorResponse("Usuario identificado como administrador. Acceso denegado.", 403);
            // }

            $validatePassword = Hash::check($password, $user->password);

            if (!$validatePassword) {
                return $this->errorResponse("Credenciales incorrectas. Int??ntalo de nuevo.", 403);
            }

            $tokenResult = $user->createToken('Pl@y3rTok3n');
            $token = $tokenResult->token;
            $token->save();
            $apiToken = $tokenResult->accessToken;
        }

        if ($user->email == 'master@apuestasg.com') {
            $role = Role::firstOrCreate(['name' => 'admin']);
            $user->assignRole($role->name);
        } else {
            $role = Role::firstOrCreate(['name' => 'player']);
            $user->assignRole($role->name);
        }

        if ($user->hasRole('admin')) {
            $o = 0;
            $menu[$o] = array(
                'titulo' => 'Usuarios',
                'icono' => 'fas fa-users-cog',
                'data' => 'Ir a Usuarios',

                'link' => 'usuarios'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Dep??sitos',
                'icono' => 'fas fa-funnel-dollar',
                'data' => 'Ir a Dep??sitos',
                'link' => 'adm-depositos'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Resultados',
                'icono' => 'fas fa-flag-checkered',
                'data' => 'Ir a Resultados',
                'link' => 'resultados'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Caballos',
                'icono' => 'fas fa-chess-knight',
                'data' => 'Ir a Caballos',
                'link' => 'caballos'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Partidos',
                'icono' => 'fab fa-patreon',
                'data' => 'Ir a Partidos',
                'link' => 'partidos'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Actualizaciones',
                'icono' => 'fas fa-redo',
                'data' => 'Ir a Actualizaciones',
                'link' => 'actualizaciones'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'TipoApuestas',
                'icono' => 'fas fa-list-ul',
                'data' => 'Ir a Tipos de Apuesta',
                'link' => 'tipoApuestas'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Nacionalidades',
                'icono' => 'far fa-flag',
                'data' => 'Ir a Nacionalidades',
                'link' => 'nacionalidades'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Ligas',
                'icono' => 'fas fa-trophy',
                'data' => 'Ir a Ligas',
                'link' => 'ligas'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Equipos',
                'icono' => 'fab fa-first-order',
                'data' => 'Ir a Equipos',
                'link' => 'equipos'
            );
            $o++;
            $menu[$o] = array(
                'titulo' => 'Mensajes',
                'icono' => 'fa fa-mail-bulk',
                'data' => 'Ir a Mensajes',
                'link' => 'mensajes/' . $token['id']
            );
            $o++;

            $menu[$o] = array(
                'titulo' => 'Promociones',
                'icono' => 'fa fa-gift',
                'data' => 'Ir a Promociones',
                'link' => 'promociones'
            );
            $o++;

            $menu[$o] = array(
                'titulo' => 'Noticias',
                'icono' => 'fa fa-newspaper',
                'data' => 'Ir a Noticias',
                'link' => 'noticias'
            );
            $o++;

            $menu[$o] = array(
                'titulo' => 'Bancos',
                'icono' => 'fa fa-university',
                'data' => 'Ir a Bancos',
                'link' => 'bancos'
            );
            $o++;

            $menu[$o] = array(
                'titulo' => 'Estad??sticas',
                'icono' => 'fa fa-percent',
                'data' => 'Ir a Estad??sticas',
                'link' => 'estadisticas/' . $token['id']
            );
            $o++;

            $menu[$o] = array(
                'titulo' => 'Changelogs',
                'icono' => 'fas fa-laptop-code',
                'data' => 'Ir a Changelogs',
                'link' => 'tareas-pendientes'
            );
            $o++;
        } elseif ($user->hasRole('player')) {
            $menu[0] = array(
                'titulo' => 'Mi Cuenta',
                'icono' => 'fa fa-universal-access',
                'data' => 'Ir a Mi Cuenta',
                'link' => 'mi-cuenta'
            );

            $menu[1] = array(
                'titulo' => 'Historial',
                'icono' => 'fa fa-history',
                'data' => 'Ir a Historial',
                'link' => 'historial'
            );

            $menu[2] = array(
                'titulo' => 'Mensajes',
                'icono' => 'fa fa-mail-bulk',
                'data' => 'Ir a Mensajes',
                'link' => 'mensajes'
            );

            $menu[3] = array(
                'titulo' => 'Promociones',
                'icono' => 'fa fa-gift',
                'data' => 'Ir a Promociones',
                'link' => 'promociones'
            );

            $menu[4] = array(
                'titulo' => 'Noticias',
                'icono' => 'fa fa-newspaper',
                'data' => 'Ir a Noticias',
                'link' => 'noticias'
            );

            $menu[5] = array(
                'titulo' => 'Bancos',
                'icono' => 'fa fa-university',
                'data' => 'Ir a Bancos',
                'link' => 'bancos'
            );

            $menu[6] = array(
                'titulo' => 'Dep??sitos',
                'icono' => 'fas fa-stream',
                'data' => 'Ir a p??gina de historial de dep??sitos',
                'link' => 'depositos'
            );

            $menu[7] = array(
                'titulo' => 'Transacciones',
                'icono' => 'fas fa-file-invoice',
                'data' => 'Ir a transacciones',
                'link' => 'transacciones'
            );

            $menu[8] = array(
                'titulo' => 'Estad??sticas',
                'icono' => 'fa fa-percent',
                'data' => 'Ir a Estad??sticas',
                'link' => 'estadisticas'
            );

            $menu[9] = array(
                'titulo' => 'Resultados',
                'icono' => 'fas fa-flag-checkered',
                'data' => 'Ir a Resultados',
                'link' => 'ver-resultados'
            );
        }

        $user->load('player');

        $data = array(
            'access_token' => $apiToken,
            'user' => $user,
            'menu' => $menu
        );

        // $this->sendMessage('Hola Carmen, se ha iniciado sesi??n correctamente en Apuestas G. A ganar.', "+51924407604");

        return $this->successResponse($data, 200);
    }

    public function loginAdmin(LoginAdminRequest $request)
    {
        $data = $request->validated();

        $email = $data['email'];
        $password = $request['password'];

        $user = User::where('email', $email)->with('admin')->first();

        if (!$user) {
            return $this->errorResponse("No existe usuario con estas credenciales", 403);
        }

        if (!$user->status) {
            return $this->errorResponse("Su cuenta se encuentra inhabiltada.", 403);
        }

        if ($user->email == 'admin@apuestasg.win') {
            $role = Role::firstOrCreate(['name' => 'admin']);
            $user->assignRole($role->name);
        }

        if (!$user->hasRole('admin')) {
            if (!$user->hasRole('player')) {
                return $this->errorResponse("Usuario identificado como jugador, acceso s??lo para administradores. Acceso denegado.", 403);
            }

            return $this->errorResponse("Acceso denegado.", 403);
        }

        $validatePassword = Hash::check($password, $user->password);

        if (!$validatePassword) {
            return $this->errorResponse("Credenciales incorrectas. Int??ntalo de nuevo.", 403);
        }

        $tokenResult = $user->createToken('ADMIN!!!!RDFTok3n');
        $token = $tokenResult->token;
        $token->save();
        $apiToken = $tokenResult->accessToken;

        $data = array(
            'access_token' => $apiToken,
            'user' => $user
        );

        Activity::create([
            "user_id" => $user->id,
            "event_type_id" => 16,
            "description" => "Inicio de sesi??n de administrador"
        ]);

        return $this->successResponse($data, 200);
    }
}
