<?php
namespace App\Presenters;

use Nette,
    App\Model;

/*
 * Show detail of given institution.
 */

class DetailPresenter extends BasePresenter
{
    public function renderDefault($urlId)
    {
        $institution = $this->db->table('institution')
                                ->where('url_id = ?', $urlId)
                                ->fetch();
        $this->template->i = $institution;
        
        $this->template->metaDescription = strip_tags($institution->short_description);
        
        $news = $this->db->query('SELECT institution.name, institution.url_id AS url_id, news.text, news.date
                                  FROM news
                                  JOIN institution ON news.id_institution = institution.id
                                  WHERE institution.id = '.$institution->id.'
                                  ORDER BY news.date DESC
                                  LIMIT 5');
        $this->template->news = $news;
    }
}
