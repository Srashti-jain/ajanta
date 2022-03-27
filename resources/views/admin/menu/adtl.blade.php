<p><b>{{ __('Linked to:') }}</b> 
	@if($link_by == 'page')
		Custom Page
	@elseif($link_by == 'url')
		Custom URL
	@else
		Custom Categories
	@endif
</p>

<p><b>{{ __("Has Mega menu:") }}</b> 
	@if($show_cat_in_dropdown == 1)
		{{ __('Yes') }}
	@elseif($show_child_in_dropdown == 1)
		{{__("Yes")}}
    @else 
    	{{__("No")}}
	@endif
</p>

<p>
	<b>Menu Icon:</b>
	@if($icon != NULL || $icon != '')
		<i class="fa {{ $icon }}"></i>
	@else
		{{__("Not set")}}
	@endif
</p>

<p>
	<b>{{ __('Menu Tag:') }}</b>
	@if($menu_tag == 1)
	{{__("Yes")}}
	@else
	{{__("Not set")}}
	@endif
</p>