<tr class="top aligned field-menu-link">
	<th class="collapsing">
		{{ $field_title }}
	</th>
	<td>
		<div class="field">
			<select name="menu_link[{{ $id_language }}][{{ $field['name'] }}][internal]"
				class="ui fluid dropdown field-menu-link-internal">
				
				<option value="">{{ trans('menu::admin.field-link.external-link') }}</option>
				@foreach ($field['data'] as $route=>$uri)
					<option value="{{ $route }}" {{ $route == $field['value'] ? 'selected' : '' }}>{{ $uri }}</option>
				@endforeach
			</select>
		</div>
		<div class="field field-menu-link-external-container" data-name="menu_link[{{ $id_language }}][{{ $field['name'] }}][external]">
			<input
				type="text" name="menu_link[{{ $id_language }}][{{ $field['name'] }}][external]"
				value="{{ array_key_exists($field['value'], $field['data']) ? '' : $field['value'] }}"
				data-name="{{ $field['name'] }}" 
				placeholder="{{ array_key_exists('placeholder', $field) ? trans($field['placeholder']) : '' }}" 
				class="field-menu-link-external {{ array_key_exists('required', $field) && $field['required'] === true ? 
					'validation-required' : '' }}" />
			<div class="error-label ui pointing red basic label"></div>
			
			@if (array_key_exists('note', $field) && $field['note'] != '')
				<div class="ui pointing label">{{ trans($field['note']) }}</div>
			@endif
		</div>
	</td>
</tr>
