<?php

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use DateTime;

/**
 * UserEvents
 */
class UserEvents implements EventListenerInterface
{

    /**
     * Implemented events
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'User.logged' => 'onUserLogged'
        ];
    }

    /**
     * On user logged event
     *
     * @param Event $event  Event.
     * @param int   $userId User id.
     * @return void
     */
    public function onUserLogged(Event $event, int $userId)
    {
        $users = TableRegistry::getTableLocator()->get('Users');

        $data = [
            'last_activity' => new DateTime()
        ];

        $user = $users->get($userId);
        $user = $users->patchEntity($user, $data);

        $users->save($user);
    }
}
