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
        
        $roles = array(
            'manager' => 'Správce instituce',
            'admin' => 'Administrátor'
        );
        $form->addSelect('role', 'Role:', $roles);
        
        $form->addSubmit('send', 'Registrovat');
        $form->onSuccess[] = callback($this, 'registerFormSubmitted');
        return $form;
    }

    public function registerFormSubmitted(UI\Form $form) {
        $values = $form->getValues();
        $new_user_id = $this->register($values);
        if ($new_user_id) {
            $this->flashMessage('Přidání uživatele proběhlo úspěšně.', "success");
            $this->redirect('Admin:usersList');
        }
    }

    public function register($data) {
        unset($data["password2"]);
        //$data["role"] = "manager";
        $data["password"] = Passwords::hash($data["password"]);
        return $this->db->table('user')->insert($data);
    }
}
