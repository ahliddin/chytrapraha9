<?php
namespace App\Presenters;

use Nette,
    App\Model;

/*
 * Map search presenter.
 */

class MapPresenter extends BasePresenter
{
    public function renderDefault($urlId)
    {
        $categories = $this->db->table('category');
        $this->template->categories = $categories;
        
        $this->template->metaDescription = 'Mapa institucí Vám pomůže najít instituci nejblíže Vašemo domovu.';
        
        
        $institutions = $this->db->table('institution')
                                 ->select('institution.*, category.name AS category_name, category.url_id AS category_url_id');
        $data = array();
        foreach ($institutions as $i) {
            $data[$i->category_url_id]['name'] = $i->category_name;
            $data[$i->category_url_id]['institutions'][] = array(
                'name' => $i->name,
                'address_street' => $i->address_street,
                'address_city' => $i->address_city,
                'address_postal_code' => $i->address_postal_code,
                'lat' => $i->lat,
                'lng' => $i->lng,
                'frontImage' => $i->front_image,
                'urlId' => $i->url_id,
                'default' => ($urlId == $i->url_id) ? true : false
            );
        }
        
        $this->template->data = $data;
        $this->template->jsonData = json_encode($data);
    }
}
