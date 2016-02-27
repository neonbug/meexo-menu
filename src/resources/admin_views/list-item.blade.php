<tr class="level-{{ $level }}">
	@if ($edit_route != null)
		<td class="collapsing">
			<a href="{{ route($edit_route, [ $item['item']->{$item['item']->getKeyName()} ]) }}" 
				class="ui label blue only-icon"><i class="write icon"></i></a>
		</td>
	@endif
	@if ($delete_route != null)
		<td class="collapsing">
			<a href="#" class="ui label red only-icon delete-item" 
				data-id-item="{{ $item['item']->{$item['item']->getKeyName()} }}"><i class="trash icon"></i></a>
		</td>
	@endif
	@foreach ($fields as $field_name=>$field)
		<?php
		$cls = (!array_key_exists('important', $field) || $field['important'] === true ? 
			'' : 'desktop-only');
		$span_style = in_array($field_name, [ 'title' ]) ? 
			'padding-left: ' . ($level-1)*24 . 'px;' : '';
		?>
		<td class="{{ $cls }}">
			<span style="{{ $span_style }}">
				@if (in_array($field_name, [ 'title' ]))
					@if ($level > 1)
						<i class="arrow right icon"></i>
					@endif
				@endif
				@include('common_admin::list_fields.' . $field['type'], 
					[ 'item' => $item['item'], 'field_name' => $field_name, 'field' => $field, 
						'route_prefix' => $route_prefix ])
			</span>
		</td>
	@endforeach
</tr>
@foreach ($item['items'] as $subitem)
	@include('menu_admin::list-item', ['level' => $level + 1, 'item' => $subitem])
@endforeach
