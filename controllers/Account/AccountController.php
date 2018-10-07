<?php

namespace controllers\Account;

use core\Abort;
use core\Redirect;
use core\View;
use middleware\MiddlewareGroup;
use model\Role;
use model\User;
use request\account\EditRequest;

class AccountController
{
    /**
     * AccountController constructor.
     *
     * Protect controller with middleware that only authenticated users can view
     */
    public function __construct()
    {
        $middlewareGroup = new MiddlewareGroup();
        $middlewareGroup->user();
        $middlewareGroup->handle();
    }

    /**
     * Create instance
     * Build view with variables
     *
     * @return string
     */
    public function index()
    {
        $account = new User();

        $view = new View('account/overview.twig');
        return $view->setData([
            'account' => $account->find($_SESSION['user'])
        ])->build();
    }

    /**
     * Create role instance
     * Create user instance
     *
     * Find user with user id
     *
     * @return string
     */
    public function edit()
    {
        $roles = new Role();
        $account = new User();

        if (!$account->find($_SESSION['user'])) {
            Abort::notFound();
        }

        $view = new View('account/edit.twig');
        return $view->setData([
            'roles' => $roles->get(),
            'account' => $account->find($_SESSION['user'])
        ])->build();
    }

    /**
     * Check request
     * Update user
     */
    public function put()
    {
        $request = new EditRequest();

        $account = new User();

        $account->update($_SESSION['user'], [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => $request->password,
            'email' => $request->email,
        ]);

        Redirect::route('account');
    }
}