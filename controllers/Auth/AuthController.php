<?php

namespace controllers\Auth;

use core\Auth;
use core\Redirect;
use core\View;
use model\Question;
use model\User;
use request\auth\LoginRequest;
use request\auth\PasswordResetRequest;


class AuthController
{
    public function loginPage()
    {
        $view = new View('login.twig');

        return $view->setData([
            'name' => 'Ricky van Waas'
        ])->build();
    }

    /**
     * Login user
     * If user is admin return to the admin overview page
     * If not return to user page
     */
    public function login()
    {
        $request = new LoginRequest();
        Auth::login($request->email, $request->password);

        if (Auth::isAdmin()) {
            Redirect::route('admin/users/overzicht');

            return;
        }

        Redirect::route('account');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();

        Redirect::route('');
    }

    /**
     * Get all questions
     * Build password-reset view
     *
     * @return string
     */
    public function passwordReset()
    {
        $question = new Question();

        $view = new View('password-reset.twig');
        return $view->setData([
            'questions' => $question->get()
        ])->build();
    }

    /**
     * Execute password reset request for checking inputs
     * Get user with the given arguments
     */
    public function passwordResetPut()
    {
        $request = new PasswordResetRequest();

        $user = new User();
        $user->getQueryBuilder()->where('email', $request->email);
        $user->getQueryBuilder()->where('question_id', $request->question_id);
        $user->getQueryBuilder()->where('question_secret', $request->secret);

        $result = $user->first();

        $user->update($result->getId(), [
            'password' => $request->password
        ]);

        Redirect::route('');
    }
}