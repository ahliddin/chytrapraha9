<?php
namespace App\Presenters;

use Nette,
    App\Model;

/*
 * List institutions of type X presenter.
 */

class ListPresenter extends BasePresenter
{
    public function renderDefault($urlId)
    {
        $category = $this->db->table('category')
                             ->where('url_id = ?', $urlId)
                             ->fetch();
        $this->template->category = $category;
        
        $institutions = $this->db->table('institution')
                                 ->select('institution.*, category.url_id AS category_url_id')
                                 ->where('id_category = ?', $category->id);
        $this->template->institutions = $institutions;
        
        $news = $this->db->query('SELECT institution.name, institution.url_id AS url_id, category.url_id AS category_url_id, news.text, news.date
                                  FROM news
                                  JOIN institution ON news.id_institution = institution.id
                                  JOIN category ON institution.id_category = category.id
                                  WHERE category.id = '.$category->id.'
                                  ORDER BY news.date DESC
                                  LIMIT 5');
        /*$news = $this->db->table('news')
                         ->select('institution.name, institution.url_id AS url_id, category.url_id AS category_url_id, news.text, news.date')
                         ->where('institution.id IN ?', $institutions);*/
        $this->template->news = $news;
    }
}
