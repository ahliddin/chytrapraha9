<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
                $router[] = new Route('', 'Homepage:default');
		$router[] = new Route('index.php', 'Homepage:default');
                $router[] = new Route('mapa-instituci', 'Map:default');
                $router[] = new Route('<url_id>', 'List:default');
                $router[] = new Route('<category_url_id>/<url_id>', 'Detail:default');
		return $router;
	}

}
