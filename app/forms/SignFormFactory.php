<?php

namespace DemoApp\Forms;

use Nette,
    Nette\Application\UI\Form,
    DemoApp\Model\UserManager,
    Nette\Security\User;


class SignFormFactory extends Nette\Object {
    /** @var User */
    private $user;

    private $manager;

    public function __construct(User $user, \DemoApp\Model\UserManager $manager) {
        $this->user = $user;
        $this->manager = $manager;
    }


    /**
     * @return Form
     */
    public function create() {
        $form = new Form;
        $form->addText('username', 'Username:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addCheckbox('remember', 'Keep me signed in');

        $form->addSubmit('send', 'Sign in');

        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }

    public function createRegister() {
        $form = new Form;
        $form->addText('username', 'Username:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addSubmit('send', 'Register');
        $form->onSuccess[] = array($this, 'registerFormSucceeded');
        return $form;
    }


    public function formSucceeded($form, $values) {
        if ($values->remember) {
            $this->user->setExpiration('14 days', FALSE);
        } else {
            $this->user->setExpiration('20 minutes', TRUE);
        }

        try {
            $this->user->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    public function registerFormSucceeded($form, $values) {
            if (! $this->manager->isUsernameValid($values->username)) {
                $form->addError('Username used');
            } else {
                $this->manager->add($values->username, $values->password);
            }
    }

}
