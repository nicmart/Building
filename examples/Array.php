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

use Building\Ary\ArrayBuilder;

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
        ->node('thomas', 'recording')
        ->push()
            ->push('ciao')
            ->node('foo', 'bar')
        ->end()
    ->end()
;

var_dump($b->get());
