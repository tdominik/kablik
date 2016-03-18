<?php

namespace DemoApp\Module\Front\Presenters;

use Nette;
use DemoApp\Forms\SignFormFactory;
use DemoApp\Model\UserManager;


class SignPresenter extends DemoApp\Module\Base\Presenters\BasePresenter


/**
 * Sign in/out presenters.
 */
  {
    /** @var SignFormFactory @inject */
    public $factory;

    /** @var UserManager @inject */
    public $manager;


    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = $this->factory->create();
        $form->onSuccess[] = function ($form) {
            $form->getPresenter()->redirect('Homepage:');
        };
        return $form;
    }

    public function actionOut() {
        $this->getUser()->logout();
        $this->flashMessage('You have been signed out.');
        $this->redirect('in');
    }


    protected function createComponentRegisterForm() {
        $form = $this->factory->createRegister();
        $form->onSuccess[] = function ($form) {
            $this->flashMessage('Account created, u can sign in.');
            $form->getPresenter()->redirect('Sign:default');
        };
        return $form;
    }


}
