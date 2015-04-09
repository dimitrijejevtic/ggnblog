<?php
/**
 * Created by PhpStorm.
 * User: Dimitrije
 * Date: 4/9/2015
 * Time: 15:41
 */



class AdminController extends BaseController{

    public function __construct(){
        $this->beforeFilter(function(){
            if(Auth::guest())
                return Redirect::to('login');
        },['except' => ['getLogin','postLogin']]);
    }
    public function getDashBoard()
    {
        $this->layout->content = View::make('dashboard');
    }

    public function getLogin()
    {
        $this->layout->content = View::make('login');
    }

    public function postLogin()
    {
        $credentials = [
            'username'=>Input::get('username'),
            'password'=>Input::get('password')
        ];
        $rules = [
            'username' => 'required',
            'password'=>'required'
        ];
        $validator = Validator::make($credentials,$rules);
        if($validator->passes())
        {
            if(Auth::attempt($credentials))
                return Redirect::to('dash-board');
            return Redirect::back()->withInput()->with('failure','username or password is invalid!');
        }
        else
        {
            return Redirect::back()->withErrors($validator)->withInput();

        }
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

}