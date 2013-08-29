<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

include '../vendor/autoload.php';

use Building\Object\ArrayBuilder;

$b = new ArrayBuilder();

$b
    ->push('a')
    ->push('b')
    ->push()
        ->push('a')
        ->node('foo', 'bar')
        ->node('moo', 'ok')
    ->end()
    ->node('foonode')
        ->array()
            ->node('thomas', 'recording')
            ->push()->array()
                ->push('ciao')
                ->node('foo', 'bar')
            ->end()->end()
        ->end()
    ->end()
;

var_dump($b->get());
