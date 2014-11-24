<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
            $news = $this->db->query('SELECT institution.name, institution.url_id AS url_id, category.url_id AS category_url_id, news.text, news.date
                              FROM news
                              JOIN institution ON news.id_institution = institution.id
                              JOIN category ON institution.id_category = category.id
                              ORDER BY news.date DESC
                              LIMIT 5');
            $this->template->news = $news;
            
            $stats = $this->db->query('SELECT category.name, COUNT(institution.id_category) as cat_count
                                       FROM category
                                       LEFT JOIN institution ON category.id = institution.id_category
                                       GROUP BY category.id');
            $this->template->stats = $stats;
	}

}
