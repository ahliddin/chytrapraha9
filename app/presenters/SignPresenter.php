<?php

namespace App\Presenters;

use Nette,
    Nette\Security\Passwords,
    Nette\Application\UI\Form;

class SignPresenter extends BasePresenter {

    /**
     * @var \App\Model\UserManager
     * @inject
     */
    public $userManager;

    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new Form;
        $form->addText('username', 'E-mail:')
                ->setRequired('Prosím, zadejte Váš e-mail.');

        $form->addPassword('password', 'Heslo:')
                ->setRequired('Prosím, zadejte Vaše heslo.');

        $form->addSubmit('send', 'Přihlásit');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = array($this, 'signInFormSucceeded');
        return $form;
    }

    public function signInFormSucceeded($form, $values) {
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->flashMessage('Vaše přihlášení proběhlo úspěšně', 'success');
            $this->redirect('Admin:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Neplatný e-mail nebo heslo.');
        }
    }

    public function actionOut() {
        $this->getUser()->logout();
            $this->flashMessage('Vaše odhlášení proběhlo úspěšně', 'success');
        $this->redirect('Sign:in');
    }

}
