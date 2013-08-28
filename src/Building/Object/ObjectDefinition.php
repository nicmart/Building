<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building\Object;


class ObjectDefinition
{
    public $className;
    public $arguments = array();
    public $methodCalls = array();
    public $propertiesSet = array();

    /**
     * @param string $className
     */
    public function __constructor($className)
    {
        $this->className = $className;
    }

    public function getObject()
    {
        $ref = new \ReflectionClass($this->className);
        $object = $ref->newInstanceArgs($this->resolveValues($this->arguments));

        foreach ($this->propertiesSet as $keyValue)
        {
            list($prop, $value) = $keyValue;
            $object->$prop = $this->resolveValue($value);
        }

        foreach ($this->methodCalls as $methodAndArgs)
        {
            list($method, $args) = $methodAndArgs;

            call_user_func_array(array($object, $method), $this->resolveValues($args));
        }

        return $object;
    }

    private function resolveValue($value)
    {
        if ($value instanceof self)
            return $value->getObject();

        return $value;
    }

    private function resolveValues(array $values)
    {
        $resolved = array();

        foreach ($values as $value)
        {
            $resolved[] = $this->resolveValue($value);
        }

        return $resolved;
    }
} 