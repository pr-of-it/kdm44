<?php

namespace App\Components\Auth;

use App\Models\User;
use T4\Mvc\Application;
use T4\Core\Session;
use T4\Auth\Exception;

class Identity
    extends \T4\Auth\Identity
{

    public function check($data)
    {
        $user = User::findByEmail($data->email);
        if (empty($user)) {
            throw new Exception('User with email ' . $data->email . ' does not exists', self::ERROR_INVALID_EMAIL);
        }
        if (!password_verify($data->password, $user->password)) {
            throw new Exception('Invalid password', self::ERROR_INVALID_PASSWORD);
        }
        return true;
    }

    public function authenticate($data)
    {
        $user = User::findByEmail($data->email);
        if (empty($user)) {
            throw new Exception('User with email '.$data->email.' does not exists', self::ERROR_INVALID_EMAIL);
        }
        if (!password_verify($data->password, $user->password)) {
            throw new Exception('Invalid password', self::ERROR_INVALID_PASSWORD);
        }
        $this->login($user);
        Application::instance()->user = $user;
        return $user;
    }

    public function getUser()
    {
        return Session::get('__user');
    }

    public function login($user)
    {
        Session::set('__user', $user);
    }

    public function logout()
    {
        Session::clear('__user');
    }

}