<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    use \Crud\Controller\ControllerTrait;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadAuthComponent();
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Configures the AuthComponent
     *
     * @return void
     */
    protected function loadAuthComponent()
    {
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginAction' => [
                'plugin' => null,
                'prefix' => false,
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => '/',
            'logoutRedirect' => '/',
            'authenticate' => [
                'all' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                ],
                'Form',
            ]
        ]);
    }

    /**
     * Check if the provided user is authorized for the request.
     *
     * @param array|\ArrayAccess|null $user The user to check the authorization of.
     *   If empty the user fetched from storage will be used.
     * @return bool True if $user is authorized, otherwise false
     */
    public function isAuthorized($user = null)
    {
        return false;
    }
}
