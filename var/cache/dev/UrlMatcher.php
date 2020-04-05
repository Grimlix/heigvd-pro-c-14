<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/demo/getTemplate' => [[['_route' => 'app_demo_getTemplate', '_controller' => 'App\\Controller\\Demo_controller::get_template'], null, null, null, false, false, null]],
        '/demo/getHttpResponse' => [[['_route' => 'app_demo_getHttpResponse', '_controller' => 'App\\Controller\\Demo_controller::get_http_response'], null, null, null, false, false, null]],
        '/demo/getRandomNumber' => [[['_route' => 'app_demo_getRandomNumber', '_controller' => 'App\\Controller\\Demo_controller::get_random_number'], null, null, null, false, false, null]],
        '/admin' => [[['_route' => 'app_admin_index', '_controller' => 'App\\Controller\\Admin_controller::index'], null, null, null, false, false, null]],
        '/admin/createPoll' => [[['_route' => 'app_admin_createPoll', '_controller' => 'App\\Controller\\Admin_controller::create_poll'], null, null, null, false, false, null]],
        '/user/getCurrentPoll' => [[['_route' => 'app_user_getCurrentPoll', '_controller' => 'App\\Controller\\User_controller::get_current_poll'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
