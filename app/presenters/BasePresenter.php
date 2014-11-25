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
    protected $db;
    protected $metaDescription;
    protected $metaKeywords;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        
        $this->metaKeywords = array();
        $this->metaDescription = "pok";

        $this->db = $database;
    }

    public function startup()
    {
        parent::startup();
                
        $categories = $this->db->table('category');
        $this->template->categories = $categories;
    }
    
    public function beforeRender()
    {
        $this->template->metaDescription = $this->metaDescription;
        $this->template->metaKeywords = $this->metaKeywords;
    }

}
