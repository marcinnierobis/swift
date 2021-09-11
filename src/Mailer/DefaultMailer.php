<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * DefaultMailer
 */
class DefaultMailer extends Mailer
{

    /**
     * Construct
     *
     * @param Mailer $email Email.
     */
    public function __construct(?Mailer $email = null)
    {
        parent::__construct($email);

        $this->viewBuilder()
            ->setLayoutPath('/layout')
            ->setTemplatePath('/email');

        $this->setEmailFormat('html');
    }
}
