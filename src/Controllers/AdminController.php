<?php namespace Neonbug\Menu\Controllers;

use App;
use Cache;
use Request;

class AdminController extends \Neonbug\Common\Http\Controllers\BaseAdminController {
	
	const CONFIG_PREFIX = 'neonbug.menu';
	const PREFIX = 'menu';
	private $model;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->model = config(static::CONFIG_PREFIX . '.model');
	}
	
	protected function getModel()        { return $this->model; }
	protected function getRepository()   { return '\Neonbug\Menu\Repositories\MenuRepository'; }
	protected function getConfigPrefix() { return self::CONFIG_PREFIX; }
	protected function getRoutePrefix()  { return 'menu'; }
	protected function getPackageName()  { return 'menu'; }
	protected function getListTitle()    { return [ 
		trans($this->getPackageName() . '::admin.title.main'), 
		trans($this->getPackageName() . '::admin.title.list')
	]; }
	protected function getAddTitle()     { return [ 
		trans($this->getPackageName() . '::admin.title.main'), 
		trans($this->getPackageName() . '::admin.title.add')
	]; }
	protected function getEditTitle()    { return [ 
		trans($this->getPackageName() . '::admin.title.main'), 
		trans($this->getPackageName() . '::admin.title.edit')
	]; }
	
	public function adminList()
	{
		$item_repo = App::make($this->getRepository());
		$items = $item_repo->getStructuredForAdminList();
		
		$params = [
			'package_name' => $this->getPackageName(), 
			'title'        => $this->getListTitle(), 
			'items'        => $items, 
			'fields'       => config($this->getConfigPrefix() . '.list.fields'), 
			'edit_route'   => $this->getRoutePrefix() . '::admin::edit', 
			'delete_route' => $this->getRoutePrefix() . '::admin::delete', 
			'add_route'    => $this->getRoutePrefix() . '::admin::add', 
			'route_prefix' => $this->getRoutePrefix()
		];
		
		return App::make('\Neonbug\Common\Helpers\CommonHelper')
			->loadAdminView(self::PREFIX, 'list', $params);
	}
	
	public function adminDeletePost()
	{
		$model = $this->getModel();
		
		$id   = Request::input('id');
		$item = $model::findOrFail($id);
		
		$item_repo = App::make($this->getRepository());
		$items = $item_repo->getStructuredForAdminDelete();
		
		$delete_ids = $this->findDeleteIds($id, $items['items']);
		foreach ($delete_ids as $delete_id)
		{		
			$this->admin_helper->deleteItem($delete_id, $model, $item->getKeyName());
			Cache::forget($this->getPackageName() . '::item::' . $item->{$item->getKeyName()});
		}
		Cache::forget($this->getPackageName() . '::items');
		
		return [ 'success' => true ];
	}
	
	protected function findDeleteIds($id, $items, $add_ids = false, $all_ids = [])
	{
		$ids = [];
		foreach ($items as $item)
		{
			$found_id = ($add_ids || ($item['item'] != null && $item['item']->{$item['item']->getKeyName()} == $id));
			$ids = $this->findDeleteIds($id, $item['items'], $found_id, $ids);
			if ($found_id)
			{
				$ids[] = $item['item']->{$item['item']->getKeyName()};
			}
		}
		return array_merge($ids, $all_ids);
	}
	
}
