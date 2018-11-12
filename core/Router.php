<?php

class Router
{
    /**
     * Number regular expression
     *
     * @var string
     */
    private const NUMBER = '[0-9]+';

    /**
     * Alpha regular expression
     *
     * @var string
     */
    private const ALPHA = '[a-zA-Z]+';

    /**
     * Any character regular expression
     *
     * @var string
     */
    private const ANY = '[\.\-_\$\$\%\*\^\(\)+a-zA-Z0-9]+';

    /**
     * Registered route list
     *
     * @var array
     */
    private $routes = [];

    /**
     * Default path config
     *
     * @var array
     */
    private $path = [
        'controller' => 'controllers/'
    ];

    /**
     * Constructor
     *
     * @param string $path
     */
    public function __construct($path = 'controllers/')
    {
        $this->path['controller'] = $path;
    }

    /**
     * Register new route into route list
     *
     * @param string $url
     * @param string|void $callback
     * @param string $method
     * @return void
     */
    private function registerRoute($url, $callback, $method = 'get')
    {
        $this->routes[] = ['url' => $url, 'callback' => $callback, 'method' => $method, 'regex' => self::getRegexUrl($url)];
    }

    /**
     * Convert pattern url to regex url
     *
     * @param string $route
     * @return string
     */
    private static function getRegexUrl($route)
    {
        $route = self::quoteRegex($route);

        $route = preg_replace('/\{:num\}/', self::NUMBER, $route);
        $route = preg_replace('/\{:alpha\}/', self::ALPHA, $route);
        $route = preg_replace('/\{[a-zA-Z0-9:$]+\}/', self::ANY, $route);

        return $route;
    }

    /**
     * Clean url string
     *
     * @param string $url
     * @return string
     */
    private static function cleanUrl($url)
    {
        return filter_var('/' . trim($url, '/'), FILTER_SANITIZE_URL);
    }

    /**
     * Quote regex
     *
     * @param string $regex
     * @return string
     */
    private static function quoteRegex($regex)
    {
        return str_replace('/', '\/', $regex);
    }

    /**
     * Get current visited url
     *
     * @return string
     */
    private static function getCurrentUrl()
    {
        return isset($_SERVER['PATH_INFO']) ? self::cleanUrl($_SERVER['PATH_INFO']) : '/';
    }

    /**
     * Get active method
     *
     * @return string
     */
    private static function getActiveMethod()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        return strtolower($method);
    }

    /**
     * Get parameter
     *
     * @param string $active
     * @param string $regex
     * @return array
     */
    private static function getParameters($active, $regex)
    {
        $regex = str_replace('\\', '', $regex);

        $active = explode('/', $active);
        $regex = explode('/', $regex);

        $params = [];

        for ($x = 0; $x < count($active); $x++) {
            if ($regex[$x] !== $active[$x]) {
                $params[] = $active[$x];
            }
        }

        return $params;
    }

    /**
     * Search and match current route to route list
     *
     * @return string
     */
    private function searchRoute()
    {
        $currentUrl = self::cleanUrl(self::getCurrentUrl());
        $activeMethod = self::getActiveMethod();

        foreach (array_reverse($this->routes) as $route) {
            if (preg_match('/^' . $route['regex'] . '$/', $currentUrl) && $activeMethod === $route['method']) {
                $route['active'] = $currentUrl;
                return $route;
            }
        }
    }

    /**
     * Run 404
     *
     * @return void
     * @throws Exception
     */
    private function run404()
    {
        throw new Exception("Route Not Registered");
    }

    /**
     * Run controller
     *
     * @param string $callback
     * @param array $params
     * @return mixed
     */
    private function runController($callback, $params)
    {
        $explode = explode('@', $callback);
        $controller = $explode[0];
        $method = $explode[1];

        require $this->path['controller'] . $controller . ".php";

        return call_user_func_array([new $controller, $method], $params);
    }

    /**
     * Load native file
     *
     * @param string $callback
     * @return void
     * @throws Exception
     */
    private function loadFile($callback)
    {
        if (!file_exists($callback)) {
            throw new Exception("File (" . $callback . ") Not found. Check File Location");
        }

        require $callback;
    }

    /**
     * Run selected route callback
     *
     * @param array $route
     * @return void
     * @throws Exception
     */
    private function runCallback($route)
    {
        $params = self::getParameters($route['active'], $route['regex']);

        if (is_callable($route['callback'])) {
            $call = call_user_func_array($route['callback'], $params);
        } elseif (preg_match('/[a-zA-Z0-9\_]+@[a-zA-Z0-9\_]+/', $route['callback'])) {
            $call = $this->runController($route['callback'], $params);
        } elseif (preg_match('/\.php/', $route['callback'])) {
            $this->loadFile($route['callback']);
        } else {
            throw new Exception("Route Invalid : " . $route['method'] . "(" . $route['url'] . ", " . $route['callback'] . ")");
        }

        if (isset($call) && !is_callable($call)) {
            print_r($call);
        }
    }

    /**
     * Filter route
     *
     * @return void
     */
    private function filterRoute()
    {
        if (substr($_SERVER['PHP_SELF'], -1) == '/') {
            $direct = rtrim($_SERVER['PHP_SELF'], '/');

            if (!preg_match('/index\.php/', $_SERVER['PHP_SELF'])) {
                $direct = preg_replace('/index\.php\//', '', $direct);
            }

            header('location:' . $direct);
        }
    }

    /**
     * Add route with get method
     *
     * @param string $route
     * @param string|closure $callback
     * @return void
     */
    public function get($route, $callback)
    {
        $this->registerRoute(self::cleanUrl($route), $callback);
    }

    /**
     * Add route with post method
     *
     * @param string $route
     * @param string|closure $callback
     * @return void
     */
    public function post($route, $callback)
    {
        $this->registerRoute(self::cleanUrl($route), $callback, 'post');
    }

    /**
     * Add route with put method
     *
     * @param string $route
     * @param string|closure $callback
     * @return void
     */
    public function put($route, $callback)
    {
        $this->registerRoute(self::cleanUrl($route), $callback, 'put');
    }

    /**
     * Add route with put method
     *
     * @param string $route
     * @param string|closure $callback
     * @return void
     */
    public function delete($route, $callback)
    {
        $this->registerRoute(self::cleanUrl($route), $callback, 'delete');
    }

    /**
     * Add route with get method
     *
     * @param string $route
     * @param string|closure $callback
     * @return void
     */
    public function page($route, $callback)
    {
        $this->registerRoute(self::cleanUrl($route), $callback);
    }

    /**
     * Run current url direct to routes
     *
     * @return void
     * @throws Exception
     */
    public function dispatch()
    {
        $route = $this->searchRoute();

        $this->filterRoute();

        if (count($route) === 0) {
            $this->run404();
        }

        $this->runCallback($route);
    }

    /**
     * Dispatch router
     *
     * @return void
     * @throws Exception
     */
    public function __destruct()
    {
        $this->dispatch();
    }

}