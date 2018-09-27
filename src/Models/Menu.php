<?php namespace Neonbug\Menu\Models;

use App;

class Menu extends \Neonbug\Common\Models\BaseModel implements \Neonbug\Common\Traits\OrdTraitInterface {
	
	protected $casts = [
		'visible' => 'boolean',
	];
	
	public static function getOrdFields() { return [ 'ord' ]; } // from OrdTraitInterface
	
}
