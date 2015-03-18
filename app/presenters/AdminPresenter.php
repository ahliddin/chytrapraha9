<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI,
    Nette\Application\UI\Form as Form,
    App\Model;


/**
 * Admin presenter.
 */
class AdminPresenter extends SecuredPresenter
{
    
    /** @persistent */
    public $institutionId;
    
    public function renderInstitutionsList() {
        $institutions = $this->db->table('institution')
                                 ->select('institution.*, category.url_id AS category_url_id');
        $this->template->institutions = $institutions;
    }

    public function renderUsersList() {
        $users = $this->db->table('user');
        $this->template->users = $users;
    }

    public function renderNewsList($institutionId) {
        $this->template->institution = $this->db->table('institution')->get($institutionId);
        
        $news = $this->db->table('news')->where('id_institution = ?', $institutionId);
        $this->template->news = $news;
    }
    
    public function renderNewsAdd($institutionId) {
        $institution = $this->db->table('institution')->get($institutionId);
        $this->template->institution = $institution;
        
        $this['newsForm']->setDefaults(array('id_institution' => $institution->id));
    }
    
    public function actionNewsRemove($newsId) {
        $this->db->table('news')->where('id = ?', $newsId)->where('id_institution = ?', $this->institutionId)->delete();
        
        $this->flashMessage('Aktualita byla smazána.', 'success');
        $this->redirect('Admin:newsList');
    }
    
    protected function createComponentNewsForm() {
        $form = new Form;
        $form->addHidden('id_institution', '0');
        $form->addTextArea('text', 'Text novinky');
        
        $form->addSubmit('send', 'Vložit aktualitu');
        $form->onSuccess[] = callback($this, 'newsFormSubmitted');
        return $form;
    }

    public function newsFormSubmitted(UI\Form $form) {
        $fValues = $form->getValues();
        $fValues['date'] = new \Nette\Utils\DateTime;
        
        
        $newsId = $this->db->table('news')->insert($fValues);
        
        $this->flashMessage('Aktualita byla vložena.', 'success');
        $this->redirect('Admin:newsList');
    }
}
