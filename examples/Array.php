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

use NicMart\Building\Native\ArrayBuilder;

$b = new ArrayBuilder();

$ary = $b
    ->push('a')
    ->push('b')
    ->push()
        ->push('a')
        ->set('foo', 'bar')
        ->set('moo', 'ok')
    ->end()
    ->set('foonode')
        ->set('thomas', 'recording')
        ->push()
            ->push('ciao')
            ->set('foo', 'bar')
        ->end()
    ->end()
->end()
;

var_dump($ary);
