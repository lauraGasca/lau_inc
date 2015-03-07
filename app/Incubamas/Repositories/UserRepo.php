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
}
