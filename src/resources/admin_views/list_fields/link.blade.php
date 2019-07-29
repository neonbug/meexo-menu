{{
	preg_match('/^\w+::slug::item-\d+/', $item->$field_name) === 1 ?
		route($item->$field_name, [], false) :
		$item->$field_name
}}
