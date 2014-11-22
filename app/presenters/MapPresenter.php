<?php
namespace App\Presenters;

use Nette,
    App\Model;

/*
 * Map search presenter.
 */

class MapPresenter extends BasePresenter
{
    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }
}
