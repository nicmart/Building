<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building\Object;
use NicMart\Building\Native\ObjectBuilder;

include '../vendor/autoload.php';

ini_set('xdebug.var_display_max_depth', '10');

$b = new ObjectBuilder('NicMart\Building\Object\Object');

$b
    ->arguments()
        ->push('foo')
        ->push('bar')
        ->object('NicMart\Building\Object\Object')
            ->method('foo')
                ->push(12)
                ->push('arg')
            ->end()
        ->end()
    ->end()
    ->prop('foo', 'bar')
    ->method('method', 1, 2, 3)
    ->prop('arrayProp')
        ->ary()
            ->set('ary')
                ->push(1)
                ->push(2)
            ->end()
            ->push('val')
            ->push()
                ->object('NicMart\Building\Object\Object')
                    ->prop('a', 'b')
                ->end()
            ->end()
        ->end()
    ->end()
;

var_dump($object = $b->end());
var_dump($object->log);

class Object
{
    public $log = array();
    public function __construct()
    {
        $this->log['args'] = func_get_args();
    }

    public function __set($name, $value)
    {
        $this->log['props'][$name] = $value;
    }

    public function __call($name, $args)
    {
        $this->log['calls'][] = array($name, $args);
    }
}