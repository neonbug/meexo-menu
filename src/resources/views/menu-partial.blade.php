<ul>
@foreach ($items as $item)
	<li>
		<a href="{{ $item['item']->parseLink('link') }}">{{ $item['item']->title }}</a>
		
		@if (sizeof($item['items']) > 0)
			@include('menu::menu-partial', [ 'items' => $item['items'] ])
		@endif
	</li>
@endforeach
</ul>
