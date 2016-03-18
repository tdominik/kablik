<?php

namespace DemoApp\Module\Front\Presenters;

use App\Model;
use Nette;
use Nette\Application\UI\Form;

class DefaultPresenter extends \DemoApp\Module\Base\Presenters\BasePresenter
{

  protected function startup()
  {
    parent::startup();

    if (!$this->getUser()->isLoggedIn()) {
      if ($this->getUser()->getLogoutReason() === Nette\Security\IUserStorage::INACTIVITY) {
        $this->flashMessage('You have been signed out due to inactivity. Please sign in again.');
      }
      $this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
    }
  }
}
