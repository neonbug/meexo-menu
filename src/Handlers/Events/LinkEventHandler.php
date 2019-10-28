<?php namespace Neonbug\Menu\Handlers\Events;

use App;
use Event;
use Route;
use Request;

class LinkEventHandler
{
	/**
	* Register the listeners for the subscriber.
	*
	* @param  Illuminate\Events\Dispatcher  $events
	* @return void
	*/
	public function subscribe($events)
	{
		$events->listen([
			'Neonbug\Common\Events\AdminAddPreparedFields', 
			'Neonbug\Common\Events\AdminEditPreparedFields'
		], function($event) {
			$this->handleAddEditPreparedFields($event);
		});
		
		$events->listen([
			'Neonbug\Common\Events\AdminAddSavePreparedFields', 
			'Neonbug\Common\Events\AdminEditSavePreparedFields'
		], function($event) {
			$this->handleAddEditSavePreparedFields($event);
		});
	}
	
	protected function handleAddEditPreparedFields($event)
	{
		$languages = App::make('LanguageRepository')->getAll();
		$languages_by_ids = [];
		foreach ($languages as $language)
		{
			$languages_by_ids[$language->id_language] = $language;
		}
		
		$lang_dep_fields = $event->fields['language_dependent'];
		foreach ($lang_dep_fields as $id_language=>$fields)
		{
			for ($i=0; $i<sizeof($fields); $i++)
			{
				$field = $fields[$i];
				
				if ($field['type'] == 'menu_admin::add_fields.link')
				{
					$event->fields['language_dependent'][$id_language][$i]['data'] =
						$this->frontendRoutes($languages_by_ids[$id_language]->locale);
				}
			}
		}
	}
	
	protected function frontendRoutes($route_language)
	{
		$found_routes = [];
		
		$routes = \Route::getRoutes();
		foreach ($routes->getRoutes() as $route)
		{
			$action = $route->getAction();
			if (array_key_exists('as', $action))
			{
				// if regexes are changed here, they should be changed in Models/Menu as well
				if (preg_match('/^.+::slug::item-\d+.*$/', $action['as']) === 1 ||
					preg_match('/^\w+::index$/', $action['as']) === 1)
				{
					$found_route = $routes->getByName($action['as'] . '::' . $route_language);
					if ($found_route !== null)
					{
						$found_routes[$action['as'] . '::' . $route_language] = $found_route->getUri();
					}
				}
			}
		}
		
		asort($found_routes);
		
		return $found_routes;
	}
	
	protected function handleAddEditSavePreparedFields($event)
	{
		//first level keys are field names, second are language ids, third are data keys, fourth are indexes
		$menu_link_data = Request::input('menu_link', []);
		
		$language_independent_fields = $event->all_language_independent_fields;
		$language_dependent_fields   = $event->all_language_dependent_fields;
		$fields = $event->fields;
		
		// translate arrays to json strings
		foreach ([
			$language_independent_fields, 
			$language_dependent_fields, 
		] as $lang_fields)
		{
			for ($i=0; $i<sizeof($lang_fields); $i++)
			{
				$field = $lang_fields[$i];
				
				if ($field['type'] == 'menu_admin::add_fields.link')
				{
					foreach ($fields as $id_language=>$field_array)
					{
						if (!array_key_exists($id_language, $menu_link_data) ||
							!array_key_exists($field['name'], $menu_link_data[$id_language]))
						{
							continue;
						}
						
						$value = $menu_link_data[$id_language][$field['name']]['internal'];
						if ($value == '')
						{
							$value = $menu_link_data[$id_language][$field['name']]['external'];
						}
						
						$event->fields[$id_language][$field['name']] = $value;
					}
				}
			}
		}
	}
}
