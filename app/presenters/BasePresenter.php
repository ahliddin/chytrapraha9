<?php

namespace App\Presenters;

use Nette,
    App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    public function startup()
    {
        parent::startup();
        
        $this->template->metaDescription = 'metaDescription';
        $this->template->metaKeywords = array('kw1', 'kw2');
    }

}
