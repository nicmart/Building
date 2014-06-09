<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building\Native;


use NicMart\Building\AbstractBuilder;

class ObjectBuilder extends AbstractBuilder
{
    private $class;

    /**
     * @param string $class
     * @param callable $callback
     *
     * @param mixed $building
     */
    public function __construct($class, callable $callback = null, $building = null)
    {
        $this->class = $class;

        return parent::__construct($callback, $building);
    }

    /**
     * @return ArrayBuilder
     */
    public function arguments(/** **/)
    {
        $args = func_get_args();
        $callback = $this->getArgumentsCallback();

        if ($args) {
            return $callback($args);
        }

        return new ArrayBuilder($callback);
    }

    /**
     * @param $methodName
     * @return ArrayBuilder
     */
    public function method($methodName/*, ...*/)
    {
        $args = func_get_args();
        array_shift($args);
        $callback = $this->getMethodCallback($methodName);

        if ($args) {
            return $callback($args);
        }

        return new ArrayBuilder($callback);
    }

    /**
     * @param $propName
     * @param null $propValue
     * @return ValueBuilder
     */
    public function prop($propName, $propValue = null)
    {
        $callback = $this->getPropCallback($propName);

        if (isset($propValue)) {
            return $callback($propValue);
        }

        return new ValueBuilder($callback);
    }


    private function getArgumentsCallback()
    {
        return function(array $arguments)
        {
            $ref = new \ReflectionClass($this->class);
            $this->building = $ref->newInstanceArgs($arguments);

            return $this;
        };
    }

    private function getPropCallback($propName)
    {
        return function($value) use ($propName)
        {
            if (!isset($this->building))
                $this->building = new $this->class;

            $this->building->$propName = $value;

            return $this;
        };
    }

    private function getMethodCallback($methodName)
    {
        return function(array $arguments) use ($methodName)
        {
            if (!isset($this->building))
                $this->building = new $this->class;

            call_user_func_array([$this->building, $methodName], $arguments);

            return $this;
        };
    }
} 