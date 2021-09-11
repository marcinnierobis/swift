<?php

declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;

/**
 * UsersMailer
 */
class UsersMailer extends DefaultMailer
{

    /**
     * Change password confirmation.
     *
     * @param User $user User entity.
     *
     * @return self
     */
    public function changePasswordConfirmation(User $user): UsersMailer
    {
        return $this
                ->setTo($user->email)
                ->setSubject(__('Your password has been changed'))
                ->setViewVars(['user' => $user]);
    }
}
