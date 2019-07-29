<script type="text/javascript">
function fieldMenuLinkUpdateDisabledStatus(field_parent, value)
{
	var external_field = $('.field-menu-link-external-container', field_parent);
	if (value.length == 0) {
		external_field.show();
	}
	else {
		external_field.hide();
	}
}

$(document).ready(function() {
	$('.field-menu-link').each(function(idx, item) {
		var dropdown = $('.ui.dropdown.field-menu-link-internal', item);
		dropdown.dropdown({
			placeholder: false,
			onChange: function(value, text, $selectedItem) {
				fieldMenuLinkUpdateDisabledStatus(item, value);
			},
		});
		
		dropdown = $('select', dropdown);
		fieldMenuLinkUpdateDisabledStatus(item, dropdown.val());
	});
});
</script>
