<?php namespace Incubamas\Repositories;

use Incubamas\Entities\User;

class UserRepo extends BaseRepo
{
        
    public function getModel()
    {
        return new User();
    }

    public  function newUser()
    {
        $user = new User();
        $user->type_id = 3;
        return $user;
    }

    public function buscarxEmail($email)
    {
        if($email<>'')
            return User::where('email','=',$email)->first();
        else
            return null;
    }

    public function actualizarPassword($user,$password)
    {
        $user->password = $password;
        $user->save();
    }

    public function actualizarImagen($imagen, $user)
    {
        $arrContextOptions=["ssl"=>["verify_peer"=>false, "verify_peer_name"=>false,],];
        $contents=file_get_contents($imagen, false, stream_context_create($arrContextOptions));
        $save_path=public_path()."/Orb/images/emprendedores/".$user->id.'.jpg';
        file_put_contents($save_path,$contents);
        $user->foto = $user->id.'.jpg';
        $user->save();
    }
}
