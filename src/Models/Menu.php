<?php namespace Neonbug\Menu\Models;

use App;

class Menu extends \Neonbug\Common\Models\BaseModel implements \Neonbug\Common\Traits\OrdTraitInterface {
	
	protected $casts = [
		'visible' => 'boolean',
	];
	
	public static function getOrdFields() { return [ 'ord' ]; } // from OrdTraitInterface
	
	public function parseLink($field_name) {
		if (mb_strlen($this->$field_name) == 0) return '';
		
		return preg_match('/^\w+::slug::item-\d+/', $this->$field_name) === 1 ?
			route($this->$field_name, [], false) :
			$this->$field_name;
	}
	
}
