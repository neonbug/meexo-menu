<?php namespace Neonbug\Menu\Controllers;

use App;
use Cache;

class Controller extends \App\Http\Controllers\Controller {
	
	const PACKAGE_NAME  = 'menu';
	const PREFIX        = 'menu';
	const CONFIG_PREFIX = 'neonbug.menu';
	
	private $model;
	
	public function __construct()
	{
		$this->model = config(static::CONFIG_PREFIX . '.model');
	}
	
	public function index()
	{
		$get_items = function() {
			$repo = App::make('\Neonbug\Menu\Repositories\MenuRepository');
			$items = $repo->getStructuredItems();
			$items = $items['items'];
			
			return $items;
		};
		
		$items = (!App::environment('production') ? $get_items() : 
			Cache::rememberForever(static::PACKAGE_NAME . '::items', $get_items));
		
		return App::make('\Neonbug\Common\Helpers\CommonHelper')
			->loadView(static::PACKAGE_NAME, 'index', [ 'items' => $items ]);
	}
	
}
