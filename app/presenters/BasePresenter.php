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
        
        $this->template->userRole = $this->getUserRole();
        $this->template->isAdmin = $this->isAdmin();
    }
    
    protected function getUserRole()
    {
        $roles = $this->getUser()->getRoles();
        if ($roles && $roles[0]) 
            return $roles[0];
        else
            return 'guest';
    }
    
    protected function isAdmin()
    {
        return $this->getUserRole() === 'admin';
    }
    
    protected function isManager()
    {
        return $this->getUserRole() === 'manager';
    }
    
    protected function isInstitutionManager($institutionId)
    {
        return $this->getUser()->getIdentity()->id_institution == $institutionId || $this->isAdmin();
    }

}
