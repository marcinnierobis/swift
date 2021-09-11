<?php

declare(strict_types=1);

namespace App\Controller;

use App\Event\UserEvents;
use Cake\Http\Response;
use Cake\Mailer\MailerAwareTrait;
use DateTime;

/**
 * Users controller
 */
class UsersController extends AppController
{

    use MailerAwareTrait;

    /**
     * Initialoze
     * 
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    /**
     * Login
     * 
     * @return Response|null
     */
    public function login()
    {
        if ($this->getRequest()->is('post')) {
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                $this->getEventManager()->on(new UserEvents());
                $this->dispatchEvent('User.logged', [$result->getData()->id]);
                $target = ['_name' => 'account'];
                $message = 'Welcome ' . $result->getData()->get('first_name');
                if ($result->getData()->get('new')) {
                    $target = ['_name' => 'change-password'];
                    $message .= ' This is your first login. Please change password for security reasons.';
                } else if ($result->getData()->get('last_activity') !== null && $result->getData()->get('last_activity') <= (new DateTime())->modify('-1 week')) {
                    $target = ['_name' => 'change-password'];
                    $message .= ' Your last activity was more than week ago. Please change password for security reasons.';
                }
                $this->Flash->success($message);
                return $this->redirect($target);
            } else {
                $this->Flash->error('Invalid username or password');
            }
        }
    }

    /**
     * Change password
     * 
     * @return Response|null
     */
    public function changePassword()
    {
        $errors = [];
        if ($this->getRequest()->is('post')) {
            $user = $this->Users->get($this->Authentication->getIdentity()->get('id'));
            $oldPassword = $user->password;
            $data = $this->getRequest()->getData();
            if ($this->checkOldPasswords($this->getRequest()->getData('password'), $oldPassword)) {
                $errors['password'][0] = 'This password was used previously.';
            } else {
                $data['new'] = false;
                $user = $this->Users->patchEntity($user, $data, ['validate' => 'password']);
                if ($this->Users->save($user)) {
                    $oldPasswordData = [
                        'user_id' => $user->id,
                        'password' => $oldPassword
                    ];
                    $this->loadModel('UserOldPasswords');
                    $entity = $this->UserOldPasswords->newEntity($oldPasswordData);
                    $this->getMailer('Users')->send('changePasswordConfirmation', [$user]);
                    $this->UserOldPasswords->save($entity);
                    $this->Flash->success('Your password has been changed');
                    return $this->redirect(['_name' => 'account']);
                } else {
                    $errors = $user->getErrors();
                }
            }
        }
        $this->set(compact('errors'));
    }

    /**
     * Check old password
     *
     * @param string $new New password.
     * @param string $old Old password.
     * @return boolean
     */
    private function checkOldPasswords($new, $old): bool
    {
        $this->loadModel('UserOldPasswords');

        $oldPasswords = $this->UserOldPasswords->find()->where(['user_id' => $this->Authentication->getIdentity()->get('id')]);
        if (!empty($oldPasswords)) {
            foreach ($oldPasswords as $oldPassword) {
                if ($this->Users->checkPassword($new, $oldPassword->password)) {
                    return true;
                }
            }
        }
        return $this->Users->checkPassword($new, $old);
    }

    /**
     * Account view
     *
     * @return void
     */
    public function account(): void
    {
        
    }

    /**
     * Logout user
     * 
     * @return Response
     */
    public function logout(): Response
    {
        $this->Authentication->logout();
        $this->Flash->success('You\'ve been logout successfully');
        return $this->redirect('/');
    }

    /**
     * Import users from CSV
     *
     * @return Response
     */
    public function importCsv(): Response
    {
        if ($this->getRequest()->is('post')) {
            $i = 0;
            $errorsChecker = false;
            $filePath = WWW_ROOT . '/import' . time() . '.csv';
            $file = $this->getRequest()->getData('file');
            $file->moveTo($filePath);
            if (empty($filePath) || !file_exists($filePath)) {
                $this->Flash->error('No file...');
            }
            if (($handle = fopen($filePath, 'rb')) !== false) {
                while (($data = fgetcsv($handle, 1000, ";", chr(8))) !== false) {
                    $i++;
                    $newUsers[$i] = [
                        'email' => $data[0],
                        'password' => $data[1],
                        'first_name' => $data[2] ?? '',
                        'last_name' => $data[3] ?? '',
                        'new' => true
                    ];
                    $record = $this->Users->newEntity($newUsers[$i]);
                    if (!empty($record->getErrors())) {
                        $errorsChecker = true;
                        $errors = $this->getValidationErrors($record->getErrors());
                        $this->Flash->error('Errors in line ' . $i . '<br>' . implode('<br>', $errors), ['key' => 'errors', 'escape' => false]);
                    }
                }
                if (!$errorsChecker) {
                    $entitites = $this->Users->newEntities($newUsers);
                    $this->Users->saveMany($entitites);
                    $this->Flash->success('Users from the file was imported sucessfully', ['key' => 'main']);
                } else {
                    $this->Flash->error('<b>Users cannot be uploaded to database. Plsaes fix all errors before uploading file again.</b>', ['key' => 'main', 'escape' => false]);
                }
            }
            unlink($filePath);
            return $this->redirect(['_name' => 'account']);
        }
    }
}
