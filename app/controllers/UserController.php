<?php

class UserController extends BaseController {

	public function __construct()
        {
            $this->beforeFilter('auth');
        }
	
	public function getIndex()
	{
		$users = User::all();
		return View::make('hello')->with('users',$users);
	}

}