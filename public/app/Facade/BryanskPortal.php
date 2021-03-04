<?php
namespace App\Facade;

use Illuminate\Support\Facades\Facade;
/**
 * Description of BryanskPortal
 *
 * @author MVManzulin
 */
class BryanskPortal extends Facade {
    protected static function getFacadeAccessor() {
        return 'BryanskPortal';
    }
}
