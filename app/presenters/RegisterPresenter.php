<?php
namespace App\Presenters;

use Nette\Application\UI,
    Nette\Application\UI\Form as Form,
    Nette\Security\Passwords;

class RegisterPresenter extends SecuredPresenter {

    /** @var users **/
    private $users;

    public function startup() {
        parent::startup();
    }

    protected function createComponentRegisterForm() {
        $form = new Form;
        $form->addText('institutionName', 'Název instituce');
        $form->addSelect('category', 'Kategorie', $this->getCategories());
        $form->addTextArea('shortDesc', 'Krátký popis');
        $form->addText('street', 'Ulice');
        $form->addText('city', 'Město');
        $form->addText('postalCode', 'PSČ');
        
        $form->addText('contactPhone', 'Kontaktní telefon');
        $form->addText('contactEmail', 'Email');
        $form->addText('contactWebsite', 'WWW');
        
        $form->addText('name', 'Jméno');
        $form->addText('surname', 'Prijmeni');
        $form->addText('email', 'E-mail: *', 35)
                ->setEmptyValue('@')
                ->addRule(Form::FILLED, 'Vyplňte Váš email')
                ->addCondition(Form::FILLED)
                ->addRule(Form::EMAIL, 'Neplatná emailová adresa');
        $form->addPassword('password', 'Heslo: *', 20)
                ->addRule(Form::FILLED, 'Vyplňte Vaše heslo');
        $form->addPassword('password2', 'Heslo znovu: *', 20)
                ->addConditionOn($form['password'], Form::VALID)
                ->addRule(Form::FILLED, 'Heslo znovu')
                ->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password']);
        
//        $roles = array(
//            'manager' => 'Správce instituce',
//            'admin' => 'Administrátor'
//        );
//        $form->addSelect('role', 'Role:', $roles);
        
        $form->addSubmit('send', 'Registrovat');
        $form->onSuccess[] = callback($this, 'registerFormSubmitted');
        return $form;
    }
    
    private function getCategories() {
        $dbCats = $this->db->table('category');
        $cats = array();
        foreach ($dbCats as $c) {
            $cats[$c->id] = $c->name;
        }
        
        return $cats;
    }

    public function registerFormSubmitted(UI\Form $form) {       
        $fValues = $form->getValues();
        
        $institutionData = array(
            'id_category' => $fValues['category'],
            'name' => $fValues['institutionName'],
            'short_description' => $fValues['shortDesc'],
            'address_street' => $fValues['street'],
            'address_city' => $fValues['city'],
            'address_postal_code' => $fValues['postalCode'],
            'contact_phone' => $fValues['contactPhone'],
            'contact_email' => $fValues['contactEmail'],
            'contact_website' => $fValues['contactWebsite']
        );
        $institutionId = $this->db->table('institution')->insert($institutionData);

        $urlString = $institutionId.'-'.\Nette\Utils\Strings::normalize($fValues['institutionName']);
        $update = array('url_id' => $urlString);
        $this->db->query('UPDATE institution SET ? WHERE id = ?', $update, $institutionId);
                
//        $this->db->table('institution')->get($institutionId)->getTable()->
        if (!$institutionId) {
            $this->flashMessage('Neporařilo se vložit instituci.', 'danger');
            $this->redirect('Admin:institutionsList');
            return ;
        }
        
        $user = array(
            'id_institution' => $institutionId,
            'name' => $fValues['name'],
            'surname' => $fValues['surname'],
            'email' => $fValues['email'],
            'password' => Passwords::hash($fValues['password']),
            'role' => 'manager'
        );
        $userId = $this->db->table('user')->insert($user);
        if (!$userId) {
            $this->flashMessage('Neporařilo se vložit uživatele.', 'danger');
            $this->redirect('Admin:institutionsList');
            return ;
        }
        
        $this->flashMessage('Objekty uživatele a instituce úspěšně vytvořeny.', 'success');
        $this->redirect('Admin:institutionsList');
    }
}
