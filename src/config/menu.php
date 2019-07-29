<?php return [
	
	'model' => '\Neonbug\Menu\Models\Menu', 
	'supports_preview' => false, 
	
	'list' => [
		'fields' => [
			'id_menu' => [
				'type' => 'text'
			], 
			'title' => [
				'type' => 'text'
			], 
			'link' => [
				'type' => 'menu_admin::list_fields.link'
			], 
			'updated_at' => [
				'type' => 'date', 
				'important' => false
			], 
			'visible' => [
				'type' => 'boolean', 
				'important' => false
			], 
			'ord' => [
				'type' => 'text', 
				'important' => false
			]
		]
	], 
	
	'add' => [
		'language_dependent_fields' => [
			[
				'name' => 'title', 
				'type' => 'single_line_text', 
				'value' => ''
			], 
			[
				'name' => 'link', 
				'type' => 'menu_admin::add_fields.link', 
				'value' => ''
			]
		], 
		'language_independent_fields' => [
			[
				'name' => 'visible', 
				'type' => 'boolean', 
				'value' => true
			], 
			[
				'name' => 'parent_id_menu', 
				'type' => 'dropdown', 
				'repository' => '\Neonbug\Menu\Repositories\MenuRepository', 
				'method' => 'structuredItemsForDropdown'
			], 
			[
				'name' => 'ord', 
				'type' => 'integer', 
				'value' => '1'
			]
		]
	], 
	
	'edit' => [
		'language_dependent_fields' => [
			[
				'name' => 'title', 
				'type' => 'single_line_text', 
				'value' => ''
			], 
			[
				'name' => 'link', 
				'type' => 'menu_admin::add_fields.link', 
				'value' => ''
			]
		], 
		'language_independent_fields' => [
			[
				'name' => 'visible', 
				'type' => 'boolean', 
				'value' => ''
			], 
			[
				'name' => 'parent_id_menu', 
				'type' => 'dropdown', 
				'skip_item_id' => true, 
				'repository' => '\Neonbug\Menu\Repositories\MenuRepository', 
				'method' => 'structuredItemsForDropdown'
			], 
			[
				'name' => 'ord', 
				'type' => 'integer', 
				'value' => '1'
			]
		]
	]
	
];
