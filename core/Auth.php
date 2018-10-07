<?php

namespace core;


use model\User;

class Auth
{
    /**
     * Check user exists with email and password combination
     * If user exist set session
     *
     * @param $email
     * @param $password
     */
    public static function login($email, $password)
    {
        $user = new User();
        $user->getQueryBuilder()->where('email', $email);
        $user->getQueryBuilder()->where('password', $password);
        $user = $user->first();


        if ($user) {
            $_SESSION['user'] = $user->getId();
        }
    }

    /**
     * Destroy authenticated session
     */
    public static function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }


    /**
     * Get authenticated user or return null
     * @return User|null
     */
    public static function user()
    {
        if (isset($_SESSION['user'])) {
            $user = new User();
            return $user->find($_SESSION['user']);
        }

        return null;
    }

    /**
     * Check user is authenticated
     *
     * @return bool
     */
    public static function isAuthenticated()
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    /**
     * Check authenticated user is active
     *
     * @return bool
     */
    public static function isActive()
    {
        $user = self::user();

        if ($user && $user->isActive()) {
            return true;
        }
        return false;
    }

    /**
     * Check authenticated user is admin
     *
     * @return bool
     */
    public static function isAdmin()
    {
        return self::isRole( 1);
    }


    /**
     * Check authenticated user is user
     *
     * @return bool
     */
    public static function isUser()
    {
        return self::isRole( 2);
    }

    /**
     * Check role id is true
     *
     * @param $roleId
     * @return bool
     */
    private static function isRole($roleId)
    {
        $user = self::user();

        if ($user && $user->getRoleId()) {
            return $user->getRoleId() == $roleId;
        }

        return false;
    }
}