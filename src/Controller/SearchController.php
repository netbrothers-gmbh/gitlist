<?php

namespace GitList\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * SearchController provides global search functionalities.
 *
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 */
class SearchController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];
        $route->get('search/{term}', function($term) use ($app) {
            $repositories = $app['git']->getRepositories($app['git.repos']);
            $candidates = [];
            foreach ($repositories as $oneRepo) {
                if (strpos($oneRepo['name'], $term) !== FALSE) {
                    $candidates[] = $oneRepo;
                }
            }
            return $app['twig']->render('index.twig', array(
                'repositories'   => $candidates,
            ));
        });
        return $route;
    }
}
