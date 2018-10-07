<?php

namespace controllers\Admin;

use core\Abort;
use core\Redirect;
use core\request\Request;
use core\Response;
use core\Validator;
use core\View;
use middleware\MiddlewareGroup;
use model\Question;
use model\Role;
use model\User;
use request\user\ActiveToggleRequest;
use request\user\CreateRequest;
use request\user\UpdateRequest;

class UserController
{
    /**
     * UserController constructor.
     * Set admin middleware for protecting that only admins can see this pages
     */
    public function __construct()
    {
        $middlewareGroup = new MiddlewareGroup();
        $middlewareGroup->admin();
        $middlewareGroup->handle();
    }

    /**
     * If GET query variable exist and is not empty
     * generate search query
     *
     * If GET query variable not exist
     * return all users
     *
     * Build view
     *
     * @return string
     */
    public function overview()
    {
        $query = null;
        $request = new Request();
        $users = new User();

        if (!empty($request->query)) {
            $query = $request->query;
            $users->getQueryBuilder()->where("CONCAT(first_name, ' ', last_name)", "%$query%", 'LIKE');
        }

        $view = new View('admin/users/overview.twig');
        return $view->setData([
            'users' => $users->get(),
            'searchQuery' => $query
        ])->build();
    }

    /**
     * Get all user roles
     * Get all questions
     *
     * Generate view
     *
     * @return string
     */
    public function create()
    {
        $roles = new Role();
        $questions = new Question();

        $view = new View('admin/users/add.twig');
        return $view->setData([
            'roles' => $roles->get(),
            'questions' => $questions->get()
        ])->build();
    }

    /**
     * Check create request
     *
     * make new User instance and save it
     * return to the admin overview
     *
     */
    public function store()
    {
        $request = new CreateRequest();

        $user = new User();
        $user->save([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => $request->password,
            'email' => $request->email,
            'is_active' => (isset($request->active)) ? 1 : 0,
            'role_id' => $request->role_id,
            'question_id' => $request->question_id,
            'question_secret' => $request->secret,
            'note' => $request->note
        ]);

        Redirect::route('admin/users/overzicht');
    }

    /**
     * Make role instance
     * Make user instance
     * Make question instance
     *
     * If user not exist return not found status code
     *
     * Build view with given variables
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $roles = new Role();
        $users = new User();
        $questions = new Question();

        if (!$users->find($id)) {
            Abort::notFound();
        }

        $view = new View('admin/users/edit.twig');
        return $view->setData([
            'roles' => $roles->get(),
            'user' => $users->find($id),
            'questions' => $questions->get()
        ])->build();
    }

    /**
     * @param $id
     *
     * Check update request
     *
     * Make user instance
     * Update user with variable
     */
    public function put($id)
    {
        $request = new UpdateRequest();

        $user = new User();

        if (!$user->find($id)) {
            Abort::notFound();
        }

        $user->update((int)$id, [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => $request->password,
            'email' => $request->email,
            'is_active' => (isset($request->active)) ? 1 : 0,
            'role_id' => $request->role_id,
            'question_id' => $request->question_id,
            'question_secret' => $request->secret,
            'note' => $request->note
        ]);

        Redirect::route('admin/users/overzicht');
    }

    /**
     * @param $id
     *
     * Make user instance
     * Check user exist
     * Build view with variables
     *
     * @return string
     */
    public function delete($id)
    {
        $user = new User();

        if (!$user->find((int)$id)) {
            Abort::notFound();
        }

        $view = new View('admin/users/delete.twig');
        return $view->setData([
            'user' => $user->find((int)$id)
        ])->build();
    }

    /**
     * @param $id
     *
     * Make user instance
     *
     * Check user not exist abort
     * Delete user
     */
    public function destroy($id)
    {
        $user = new User();

        if (!$user->find((int)$id)) {
            Abort::notFound();
        }

        $user = new User();
        $user->delete($id);

        Redirect::route('admin/users/overzicht');
    }

    /**
     * @return false|string
     */
    public function activeToggle()
    {
        $request = new ActiveToggleRequest();

        if (Validator::hasErrors()) {
            return Response::json([
                'errors' => Validator::getErrors()
            ], 400);
        }

        $user = new User();
        $user->find($request->id);

        $user->update($request->id, [
            'is_active' => $request->is_active
        ]);

        return Response::json([
            'update' => true
        ]);
    }
}