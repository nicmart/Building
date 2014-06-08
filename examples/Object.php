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
include '../vendor/autoload.php';

ini_set('xdebug.var_display_max_depth', '10');

$b = new ObjectBuilder('Building\Object\Object');

$b
    ->arguments()
        ->value('foo')
        ->value('bar')
        ->object('Building\Object\Object')
            ->method('foo')
                ->value(12)
                ->value('arg')
            ->end()
        ->end()
    ->end()
    ->prop('foo', 'bar')
    ->method('method', array(1,2,3))
    ->prop('arrayProp')
        ->array()
            ->node('ary')
                ->array()
                    ->push(1)->push(2)
                ->end()
            ->end()
            ->push('val')
            ->push()
                ->object('Building\Object\Object')->prop('a', 'b')->end()
            ->end()
        ->end()
    ->end()
;

var_dump($b->get());
var_dump($b->get()->getObject()->log);

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