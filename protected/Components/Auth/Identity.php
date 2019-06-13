<?php

namespace App\Components\Auth;

use App\Dto\UserRegister\RequestDto;
use App\Exceptions\ConflictException;
use App\Models\Role;
use App\Models\User;
use T4\Core\MultiException;
use T4\Mvc\Application;
use T4\Core\Session;
use T4\Auth\Exception;

/**
 * Class Identity
 * @package App\Components\Auth
 */
class Identity
    extends \T4\Auth\Identity
{
    /**
     * @param RequestDto $data
     * @return User
     * @throws MultiException
     * @throws \T4\Core\Exception
     */
    public function register(RequestDto $data)
    {
        $errors = new MultiException();

        if (!empty(User::findByEmail($data->email))) {
            $errors->add(new ConflictException('Пользователь с таким email уже зарегистрирован'));
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        try {
            $user = new User();
            $user->fill([
                'email'     => $data->email,
                'password'  => password_hash($data->password, PASSWORD_DEFAULT),
                'first_name' => $data->firstName,
                'middle_name'  => $data->middleName,
                'last_name' => $data->lastName ?? null,
                'organization' => $data->organization ?? null,
                'phone' => $data->phone ?? null,
                'role' => (Role::findByColumn('name','user'))->getPk(),
            ]);
        } catch (MultiException $e) {
            throw $e;
        }

        $user->save();

        return $user;
    }

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