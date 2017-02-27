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
    }

    public function isAuthorized($user = null) 
    {
        if ($this->request->param('action') == 'logout') {
            return true;
        }
        return parent::isAuthorized($user);
    }
}
