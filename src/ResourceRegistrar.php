<?php

namespace AriMahmudRana\laravelResourceRouteWildcardAlias;

use Illuminate\Support\Str;
use Illuminate\Routing\ResourceRegistrar as ResourceRegistrarMain;

class ResourceRegistrar extends ResourceRegistrarMain
{

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array   $options
     * @return void
     */
    public function register($name, $controller, array $options = [])
    {
        if (isset($options['alias']) && !empty($options['alias']) && is_array($options['alias']))
        {
            $aliases = [];
            foreach($options['alias'] as $key => $value)
            {
                $aliases[$this->getResourceWildcard($key)] = $value;
            }
            $options['alias'] = $aliases;
        }

        parent::register($name, $controller, $options);
    }

    /**
     * Get the base resource URI for a given resource.
     *
     * @param  string  $resource
     * @param  array   $options
     * @return string
     */
    public function getResourceUri($resource, array $options = [])
    {
        if (! Str::contains($resource, '.')) {
            return $resource;
        }

        // Once we have built the base URI, we'll remove the wildcard holder for this
        // base resource name so that the individual route adders can suffix these
        // paths however they need to, as some do not have any wildcards at all.
        $segments = explode('.', $resource);

        $uri = $this->getNestedResourceUri($segments, $options);

        $base = $this->getResourceWildcard(end($segments));

        return str_replace('/{'. (isset($options['alias'][$base])?$options['alias'][$base]:$base) .'}', '', $uri);
    }

    /**
     * Get the URI for a nested resource segment array.
     *
     * @param  array   $segments
     * @param  array   $options
     * @return string
     */
    protected function getNestedResourceUri(array $segments, array $options = [])
    {
        // We will spin through the segments and create a place-holder for each of the
        // resource segments, as well as the resource itself. Then we should get an
        // entire string for the resource URI that contains all nested resources.
        return implode('/', array_map(function ($s) use ($options) {
            $base = $this->getResourceWildcard($s);

            return $s.'/{'. (isset($options['alias'][$base])?$options['alias'][$base]:$base) .'}';

        }, $segments));
    }

    /**
     * Add the index method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceIndex($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options);

        $action = $this->getResourceAction($name, $controller, 'index', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the create method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceCreate($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options).'/create';

        $action = $this->getResourceAction($name, $controller, 'create', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the store method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceStore($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options);

        $action = $this->getResourceAction($name, $controller, 'store', $options);

        return $this->router->post($uri, $action);
    }

    /**
     * Add the show method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceShow($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options).'/{'.(isset($options['alias'][$base])?$options['alias'][$base]:$base).'}';

        $action = $this->getResourceAction($name, $controller, 'show', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the edit method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceEdit($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options).'/{'.(isset($options['alias'][$base])?$options['alias'][$base]:$base).'}/edit';

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the update method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return void
     */
    protected function addResourceUpdate($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options).'/{'.(isset($options['alias'][$base])?$options['alias'][$base]:$base).'}';

        $action = $this->getResourceAction($name, $controller, 'update', $options);

        return $this->router->match(['PUT', 'PATCH'], $uri, $action);
    }

    /**
     * Add the destroy method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDestroy($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name, $options).'/{'.(isset($options['alias'][$base])?$options['alias'][$base]:$base).'}';

        $action = $this->getResourceAction($name, $controller, 'destroy', $options);

        return $this->router->delete($uri, $action);
    }
}
