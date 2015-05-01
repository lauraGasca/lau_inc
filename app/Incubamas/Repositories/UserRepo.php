<?php namespace Incubamas\Repositories;

use Incubamas\Entities\User;

class UserRepo extends BaseRepo
{
    public function getModel()
    {
        return new User();
    }

    public function newUser()
    {
        $user = new User();
        $user->type_id = 3;
        return $user;
    }

    public  function newUserAct()
    {
        $user = new User();
        $user->type_id = 3;
        $user->active = 1;
        $user->password = '1234';
        return $user;
    }

    public function usuario($id)
    {
        return User::find($id);
    }

    public function buscarxEmail($email)
    {
        if($email<>'')
            return User::where('email','=',$email)->first();
        else
            return null;
    }

    public function listar_asesores()
    {
        return User::where('type_id', '=', 2)->where('active', '=', 1)->orderBy('apellidos', 'asc')->get()->lists('FullName','id');
    }

    public function listar_emprendedores()
    {
        return User::where('type_id', '=', 3)->where('active', '=', 1)->orderBy('apellidos', 'asc')->get()->lists('FullName','id');
    }

    public function actualizarPassword($user)
    {
        $password = $this->_password();
        $user->password = $password;
        $user->save();
        return $password;
    }

    public function guardarFoto($imagen, $user)
    {
        $arrContextOptions=["ssl"=>["verify_peer"=>false, "verify_peer_name"=>false,],];
        $contents=file_get_contents($imagen, false, stream_context_create($arrContextOptions));
        $save_path=public_path()."/Orb/images/emprendedores/".$user->id.'.jpg';
        file_put_contents($save_path,$contents);
        $user->foto = $user->id.'.jpg';
        $user->save();
    }

    public function actualizarFoto($user, $foto)
    {
        $this->borrarFoto($user->foto);
        $user->foto = $foto;
        $user->save();
    }

    public function crearNomUser($user)
    {
        $nombre = explode(" ", $user->nombre);
        $user->user = $user->id.$nombre[0];
        $user->save();
    }

    public function borrarUsuario($id)
    {
        $user = User::find($id);
        $this->borrarFoto($user->foto);
        $user->delete();
    }

    public function borrarFoto($foto)
    {
        if ($foto <> 'generic-emprendedor.png')
            \File::delete(public_path() . '/Orb/images/emprendedores/'.$foto);
    }

    //Genera una contraseña aleatoriamente
    private function _password()
    {
        $val_permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890?!*-+_%#/=()";
        $cad = "";
        for($i=0;$i<8;$i++) {
            $cad .= substr($val_permitidos,rand(0,62),1);
        }
        return $cad;
    }

}
