<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        $this->Crud->mapAction('login', 'CrudUsers.Login');
        $this->Crud->mapAction('logout', 'CrudUsers.Logout');
        $this->Crud->mapAction('forgotPassword', 'CrudUsers.ForgotPassword');
        $this->Crud->mapAction('resetPassword', [
            'className' => 'CrudUsers.ResetPassword',
            'findMethod' => 'token',
        ]);
        $this->Crud->mapAction('verify', [
            'className' => 'CrudUsers.Verify',
            'findMethod' => 'token',
        ]);
        $this->Auth->allow(['forgotPassword', 'resetPassword', 'verify']);

        $this->Crud->addListener('Users', 'App\Listener\UsersListener');
    }

    public function isAuthorized($user = null) 
    {
        if ($this->request->param('action') == 'logout') {
            return true;
        }
        return parent::isAuthorized($user);
    }
}
