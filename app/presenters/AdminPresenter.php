<?php

namespace App\Presenters;

use Nette,
    App\Model;


/**
 * Admin presenter.
 */
class AdminPresenter extends SecuredPresenter
{
    public function renderInstitutionsList() {
        $institutions = $this->db->table('institution')
                                 ->select('institution.*, category.url_id AS category_url_id');
        $this->template->institutions = $institutions;
    }

    public function renderUsersList() {
        $users = $this->db->table('user');
        $this->template->users = $users;
    }

}
