<?php

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Database\Connection;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    
    /** @var Nette\Database\Context */
    private $db;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();

        $this->db = $database;
    }

    public function startup()
    {
        parent::startup();
        
        $this->template->metaDescription = 'metaDescription';
        $this->template->metaKeywords = array('kw1', 'kw2');
        
        
                
        $categories = $this->db->table('category');
        $this->template->categories = $categories;
    }

}
