<?php
namespace App\Listerner;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\TableRegistry;
use Crud\Listener\BaseListener;

/**
 * Users Listener
 */
class UsersListener extends BaseListener 
{
    use MailerAwareTrait;

    /**
     * Default config for this object
     *
     * @var array 
     */
    protected $_defaultConfig = [
        'mailer' => 'User',
    ];
    /**
    * Callbacks definition
    *
    * @return array
    */
    public function implementedEvents()
    {
        return [
            'Crud.afterForgotPassword' => 'afterForgotPassword',
            'Crud.verifyToken' => 'verifyToken',
        ];
    }

    /**
     * After Forgot Password
     *
     * @param \Cake\Event\Event $event Event
     * @return void
     **/
    public function afterForgotPassword(Event $event)
    {
        if (!$event->subject->success) {
            return;
        }

        $table = TableRegistry::get($this->_controller()->modelClass);
        $token = $table->tokenize($event->subject->entity->id);
        if ($this->config('mailer')) {
            $this->getMailer($this->config('mailer'))->send('forgotPassword', [
                $event->subject->entity->toArray(),
                $token,
            ]);
        }
    }

    /**
     * Before Verify
     *
     * @param \Cake\Event\Event $event Event
     * @return void
     */
    public function verifyToken(Event $event)
    {
        $event->subject->verified = TableRegistry::get('Muffin/Tokenize.Tokens')
            ->verify($event->subject->token);
    }

}