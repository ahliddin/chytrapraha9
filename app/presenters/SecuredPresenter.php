<?php

namespace App\Presenters;

use Nette,
    App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class SecuredPresenter extends BasePresenter
{
    

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct($database);
    }

    public function startup()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Nejprve se prosím přihlašte', 'danger');
            $this->redirect('Sign:in');
        }
        
        parent::startup();
    }

}
