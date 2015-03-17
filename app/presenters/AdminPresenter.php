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

    public function renderNewsList($id) {
        $this->template->institution = $this->db->table('institution')->get($id);
        
        $news = $this->db->table('news')->where('id_institution = ?', $id);
        $this->template->news = $news;
    }

}
