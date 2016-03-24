<?php

/**
 * Class Route
 */
class Route
{

    /**
     * Start routing method
     */
    static function start()
    {
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;
        if (file_exists($model_path)) {
            include $model_path;
        }

        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "application/controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            Route::ErrorPage404();
        }

        $cofig_dir_path = "application/config";
        if (is_dir($cofig_dir_path)) {
            $config_file_list = scandir($cofig_dir_path);
            foreach ($config_file_list as $config_file) {
                if (!in_array($config_file, array(".", ".."))) {
                    $curr_file = $cofig_dir_path . DIRECTORY_SEPARATOR . $config_file;
                    if (file_exists($curr_file)) {
                        $conf = require $curr_file;
                        foreach ($conf as $name_row => $row) {
                            Gonfiguration::set($name_row, $row);
                        }
                    }
                }
            }
        } else {
            Route::ErrorPage404();
        }

        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::ErrorPage404();
        }

    }

    /**
     * Error page method
     */
    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }

}
