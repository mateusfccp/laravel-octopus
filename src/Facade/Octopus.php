<?php 

namespace Octopus\Facade;

use Illuminate\Support\Facades\Facade;
 
/**
 * Octopus ─ Facade to support integration with Laravel framework
 *
 * @author Mateus Felipe <mateusfccp@gmail.com>
 * @package Octopus
 * @version 0.1.0
 */
class Octopus extends Facade {
    protected static function getFacadeAccessor() { return 'octopus'; }
}
