<?php namespace Neonbug\Menu\Repositories;

use App;

class MenuRepository {
	
	const CONFIG_PREFIX = 'neonbug.menu';
	
	protected $model;
	
	public function __construct()
	{
		$this->model = config(static::CONFIG_PREFIX . '.model');
	}
	
	public function getStructuredItems()
	{
		$language      = App::make('Language');
		$resource_repo = App::make('ResourceRepository');
		
		$model = $this->model;
		$items = $model::where('visible', true)->orderBy('ord')->get();
		$resource_repo->inflateObjectsWithValues($items, $language->id_language);
		
		$structured_items = $this->findItems(null, $items);
		
		return $structured_items;
	}
	
	public function getForAdminList()
	{
		$model = $this->model;
		return $model::orderBy('ord')->get();
	}
	
	public function getStructuredForAdminList()
	{
		$language      = App::make('Language');
		$resource_repo = App::make('ResourceRepository');
		
		$model = $this->model;
		$items = $model::orderBy('ord')->get();
		$resource_repo->inflateObjectsWithValues($items, $language->id_language);
		
		$structured_items = $this->findItems(null, $items);
		
		return $structured_items;
	}
	
	public function getStructuredForAdminDelete()
	{
		$model = $this->model;
		$items = $model::orderBy('ord')->get();
		
		$structured_items = $this->findItems(null, $items);
		
		return $structured_items;
	}
	
	protected function findItems($parent_item, $items)
	{
		$selected_items = [
			'item' => $parent_item, 
			'items' => []
		];
		$parent_id = ($parent_item == null ? null : $parent_item->id_menu);
		foreach ($items as $item)
		{
			if ($item->parent_id_menu == $parent_id)
			{
				$structured_subitems = $this->findItems($item, $items);
				$selected_items['items'][] = $structured_subitems;
			}
		}
		return $selected_items;
	}
	
	public function structuredItemsForDropdown()
	{
		$language      = App::make('Language');
		$resource_repo = App::make('ResourceRepository');
		
		$model = $this->model;
		$items = $model::orderBy('ord')->get();
		$resource_repo->inflateObjectsWithValues($items, $language->id_language);
		
		$values = $this->findItemsForDropdown(null, $items);
		
		return $values;
	}
	
	protected function findItemsForDropdown($parent_item, $items, $prev_items = [], $level = 0)
	{
		$selected_items = [];
		$title = null;
		if ($parent_item != null)
		{
			$title = $parent_item->title;
			$selected_items[$parent_item->id_menu] = implode(' ➞ ', $prev_items) . 
				(sizeof($prev_items) > 0 ? ' ➞ ' : '') . $title;
		}
		
		$parent_id = ($parent_item == null ? null : $parent_item->id_menu);
		foreach ($items as $item)
		{
			if ($item->parent_id_menu == $parent_id)
			{
				$subitems = $this->findItemsForDropdown($item, $items, 
					($title == null ? $prev_items : array_merge($prev_items, [ $title ])), 
					$level+1);
				$selected_items = $selected_items + $subitems;
			}
		}
		return $selected_items;
	}
	
}
