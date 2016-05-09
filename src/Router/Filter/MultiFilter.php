<?php

namespace Phwoolcon\Router\Filter;

use Phalcon\Mvc\Router\Route;
use Phwoolcon\Router;
use Phwoolcon\Router\FilterInterface;
use Phwoolcon\Router\FilterTrait;

class MultiFilter implements FilterInterface
{
    /**
     * @var FilterInterface[]
     */
    protected $filters = [];

    use FilterTrait;

    public function add(FilterInterface $filter)
    {
        $this->filters[get_class($filter)] = $filter;
        return $this;
    }

    /**
     * @param string $uri
     * @param Route  $route
     * @param Router $router
     * @return bool
     */
    protected function filter($uri, $route, $router)
    {
        foreach ($this->filters as $filter) {
            if (!$filter->__invoke($uri, $route, $router)) {
                return false;
            }
        }
        return true;
    }

    public function remove($key)
    {
        unset($this->filters[$key]);
        return $this;
    }
}
