<?php
namespace app\router;

use app\Database;

class Router
{
        public Database $dbs;
        public array $getRoutes = [];
        public array $postRoutes = [];

        public function __construct(Database $db)
        {
                $this->dbs = $db;
        }
        public function get($url, $fn)
        {
                $this->getRoutes[$url] = $fn;
        }
        public function post($url, $fn)
        {
                $this->postRoutes[$url] = $fn;
        }
        public function resolve()
        {
                $currUrl = $_SERVER['PATH_INFO'] ?? '/';
                $method = $_SERVER['REQUEST_METHOD'];

                if ($method === 'GET')
                {
                        $fn = $this->getRoutes[$currUrl] ?? null;
                }
                else
                {
                        $fn = $this->postRoutes[$currUrl] ?? null;
                }
                if (!$fn)
                {
                        echo "404 not found!";
                }
                call_user_func($fn, $this);
        }

        public function renderView ($view, $params = [])
        {
                echo '<pre>';
                var_dump($_SERVER);
                echo '</pre>';
                //exit;
                foreach ($params as $key => $value) {
                        $$key = $value; 
                }

                ob_start();
                include_once __DIR__."/../../views/$view.php";
                $content = ob_get_clean();
                include_once __DIR__."/../../views/layouts/layout.php";
        }
}
?>