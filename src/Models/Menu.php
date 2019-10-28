<?php namespace Neonbug\Menu\Models;

use App;
use InvalidArgumentException;

class Menu extends \Neonbug\Common\Models\BaseModel implements \Neonbug\Common\Traits\OrdTraitInterface {
	
	protected $casts = [
		'visible' => 'boolean',
	];
	
	public static function getOrdFields() { return [ 'ord' ]; } // from OrdTraitInterface
	
	public function parseLink($field_name) {
		if (mb_strlen($this->$field_name) == 0) return '';
		
		$route = $this->$field_name;
		try {
			// if regexes are changed here, they should be changed in LinkEventHandler as well
			$route = preg_match('/^.+::slug::item-\d+.*$/', $this->$field_name) === 1 ||
				preg_match('/^\w+::index/', $this->$field_name) === 1 ?
				route($this->$field_name, [], false) :
				$this->$field_name;
		}
		catch (InvalidArgumentException $e) {}
		
		return $route;
	}
	
}
