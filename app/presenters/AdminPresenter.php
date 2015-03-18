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
        
        if (!$this->isAdmin()) {
            $institutions = $institutions->where('institution.id = ?', $this->getUser()->getIdentity()->id_institution);
        }
        
        $this->template->institutions = $institutions;
    }

    public function renderUsersList() {
        if (!$this->isAdmin()) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Homepage:');
        }
        
        $users = $this->db->table('user');
        $this->template->users = $users;
    }

    public function renderNewsList($institutionId) {
        if (!$this->isInstitutionManager($institutionId)) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Admin:');
        }
        
        $this->template->institution = $this->db->table('institution')->get($institutionId);
        
        $news = $this->db->table('news')->where('id_institution = ?', $institutionId);
        $this->template->news = $news;
    }
    
    public function renderNewsAdd($institutionId) {
        if (!$this->isInstitutionManager($institutionId)) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Admin:');
        }
        
        $institution = $this->db->table('institution')->get($institutionId);
        $this->template->institution = $institution;
        
        $this['newsForm']->setDefaults(array('id_institution' => $institution->id));
    }
    
    public function actionNewsRemove($newsId) {
        if (!$this->isInstitutionManager($this->institutionId)) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Admin:');
        }
        
        $this->db->table('news')->where('id = ?', $newsId)->where('id_institution = ?', $this->institutionId)->delete();
        
        $this->flashMessage('Aktualita byla smazána.', 'success');
        $this->redirect('Admin:newsList');
    }
    
    public function actionInstitutionRemove($institutionId) {
        if (!$this->isAdmin()) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Homepage:');
        }
        
        $this->db->table('institution')->where('id = ?', $institutionId)->delete();
        $this->db->table('user')->where('id_institution = ?', $institutionId)->delete();
        $this->db->table('news')->where('id_institution = ?', $institutionId)->delete();
        $this->db->table('rating')->where('id_institution = ?', $institutionId)->delete();
        
        $this->flashMessage('Instituce a všechny odpovídající záznamy byly smazány.', 'success');
        $this->redirect('Admin:institutionsList');
    }
    
    public function renderInstitutionEdit($institutionId) {
        if (!$this->isInstitutionManager($institutionId)) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Admin:');
        }
        
        $institution = $this->db->table('institution')->get($institutionId);
        $this->template->institution = $institution;
        
        
        $this['institutionEditForm']->setDefaults($institution);
    }
    
    protected function createComponentInstitutionEditForm() {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('name', 'Název instituce');
        $form->addSelect('id_category', 'Kategorie', $this->getCategories());
        $form->addTextArea('short_description', 'Krátký popis');
        $form->addTextArea('text', 'Text');
        $form->addUpload('front_image', 'Obrázek')
             ->addCondition(Form::FILLED)
             ->addRule(Form::IMAGE, 'Obrázek musí být JPEG nebo PNG.');
        $form->addText('address_street', 'Ulice');
        $form->addText('address_city', 'Město');
        $form->addText('address_postal_code', 'PSČ');
        $form->addText('contact_phone', 'Telefon');
        $form->addText('contact_email', 'Email');
        $form->addText('contact_website', 'WWW');
        $form->addTextArea('contact_others', 'Další kontakty');
        $form->addText('lat', 'GPS šírka');
        $form->addText('lng', 'GPS délka');
        
        $form->onSuccess[] = callback($this, 'institutionEditFormSubmitted');
        $form->addSubmit('send', 'Uložit');
        return $form;
    }

    public function institutionEditFormSubmitted(UI\Form $form) {
        $fValues = $form->getValues();
        
        $institutionId = $fValues['id'];
        
        
        if (!$this->isInstitutionManager($institutionId)) {
            $this->flashMessage('Neoprávněný přístup', 'danger');
            $this->redirect('Admin:');
        }
        
        if ($institutionId) {
            $institution = $this->db->table('institution')->get($institutionId);
        } else {
            $this->flashMessage('Při ukládání dat došlo k chybě.', 'warning');
            $this->redirect('Admin:institutionsList');
        }
        
        if ($fValues['front_image']->isOk()) {
            $filename = $fValues['front_image']->getSanitizedName();
            $imagePath = WWW_DIR.'/img/institutions/'.$institution->front_image;
            if (is_file($imagePath)) {
                unlink($imagePath);
            }
            //die($fValues['front_image']->getContentType());
            switch ($fValues['front_image']->getContentType()) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                default:
                    $this->flashMessage('Při ukládání dat došlo k chybě.', 'warning');
                    $this->redirect('Admin:institutionsList');
                    return ;
                    break;
            }
            $newImagePath = WWW_DIR.'/img/institutions/'.$institution->id.'.'.$extension;
            $fValues['front_image']->move($newImagePath);
            $fValues['front_image'] = $institution->id.'.'.$extension;
        } else {
            unset($fValues['front_image']);
        }
        
        $institution->update($fValues);
        
        $this->flashMessage('Úpravy instituce '.$institution->name.' byly uloženy.', 'success');
        $this->redirect('Admin:institutionsList');
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
    
    private function getCategories() {
        $dbCats = $this->db->table('category');
        $cats = array();
        foreach ($dbCats as $c) {
            $cats[$c->id] = $c->name;
        }
        
        return $cats;
    }
}
