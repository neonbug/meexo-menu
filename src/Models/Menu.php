<?php namespace Neonbug\Menu\Models;

use App;

class Menu extends \Neonbug\Common\Models\BaseModel implements \Neonbug\Common\Traits\OrdTraitInterface {
	
	public static function getOrdFields() { return [ 'ord' ]; } // from OrdTraitInterface
	
}
