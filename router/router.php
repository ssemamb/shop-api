<?php
class Router
{
    private $routes = [];
    private $baseUrl = '/shop-api/v1';
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    //add routes to the routes array 
    public function add($method, $Url, $callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException("The provided callback for the route {$Url} is not callable");
        }
        $Url = $this->baseUrl . $Url;
        $this->routes[] = [
            'method' => strtoupper($method),
            'Url' => $Url,
            'callback' => $callback
        ];
        return $this;
    }

    //group  routes with a commmon prefix
    public function group($prefix, $callback)
    {

        $previousbaseurl = $this->baseUrl;
        $this->baseUrl .= $prefix;
        $callback($this);
        $this->baseUrl = $previousbaseurl;
    }

    //dispatch requests to the provided routes
    public function dispatch($method, $Url)
    {
        foreach ($this->routes as $route) {
            //dynamic routing

            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([a-zA-Z0-9_-]+)', $route['Url']);
            if ($route['method'] === strtoupper($method) && preg_match('#^' . $pattern . '$#', $Url, $matches)) {
                array_shift($matches);
                //include query params
                $queryparams = '%query';
                $passedUrl = parse_url($Url);
                if (isset($passedUrl['query'])) {
                    parse_str($passedUrl['query'], $queryparams);
                }

                return call_user_func($route['callback'], $matches, $queryparams);
            }
        }
        return $this->handleError($method, $Url);
    }

    public function handleError($method, $Url)
    {
        foreach ($this->routes as $route) {
            if ($route['Url'] === $Url && $route['method'] != strtoupper($method)) {
                return $this->methodnotAllowed();
            }
        }
        return $this->notfound();
    }

    public function methodnotAllowed()
    {
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['error' => 'Method Not Allowed']);
    }
    public function notfound()
    {
        header('HTTP/1.1 400 Not Found');
        echo json_encode(['error' => 'Route Not found']);
    }
}
