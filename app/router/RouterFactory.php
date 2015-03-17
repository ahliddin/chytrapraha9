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
        $router[] = new Route('registrace', 'Register:default');
        $router[] = new Route('prihlaseni', 'Sign:in');
        $router[] = new Route('odhlaseni', 'Sign:out');
        $router[] = new Route('admin', 'Admin:default');
        $router[] = new Route('mapa-instituci[/<urlId>]', 'Map:default');
        $router[] = new Route('<urlId>', 'List:default');
        $router[] = new Route('<categoryUrlId>/<urlId>', 'Detail:default');
        return $router;
    }

}
