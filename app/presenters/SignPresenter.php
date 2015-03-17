<?php

namespace App\Presenters;

use Nette,
	Nette\Security\Passwords,
	Nette\Application\UI\Form;


class SignPresenter extends BasePresenter
{

    /**
     * @var \App\Model\UserManager
     * @inject
     */
    public $userManager;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form;
		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign in');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = array($this, 'signInFormSucceeded');
		return $form;
	}


	public function signInFormSucceeded($form, $values)
	{
		try {
            $this->getUser()->login($values->username,
                $values->password);
			$this->redirect('Homepage:');

		} catch (Nette\Security\AuthenticationException $e) {
            $form->addError(Passwords::hash($values->password));
			$form->addError('Incorrect username or password.');
		}
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('Homepage:');
	}
}