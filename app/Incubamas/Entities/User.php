<?php namespace Incubamas\Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface
{
	use UserTrait, RemindableTrait;

	protected $table = 'users';
    protected $guarded = ['id', 'foto', 'password_confirmation'];
	protected $hidden = ['password', 'remember_token'];
	
	public function setPasswordAttribute($value)
    {
		if(!empty($value))
		{
			$this->attributes['password'] = \Hash::make($value);
		}
	}
	
	public function getRememberToken()
	{
	    return $this->remember_token;
	}

    public function getNameToken()
    {
        return $this->nombre.' '.$this->apellidos;
    }

    public function getUrlToken()
    {
        return 'Orb/images/emprendedores/'.$this->foto;
    }
	
	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}
	
	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

    public function getFullNameAttribute()
    {
        return $this->apellidos.' '.$this->nombre;
    }

}
