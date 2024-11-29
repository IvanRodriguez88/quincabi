@php
	$icon = isset($config['icon']) ? $config['icon'] : "";
@endphp
<x-adminlte-modal 
	id="{{$id}}" 
	title="{{$title}}" 
	size="{{$size}}" 
	theme="light"
	icon="{{$icon}}"
	v-centered static-backdrop scrollable>

	<div id="error-messages">

	</div>
	<div>
		<form id="{{$id.'-form'}}" action="{{$idEdit == null ? route($action) : route($action, $idEdit)}}" method="{{$method ?? "post"}}">
			@csrf
			@if (isset($idEdit))
				@method('put')
			@else
				@method('post')
			@endif
			{!! $fields !!}

			<x-slot name="footerSlot">
				<x-adminlte-button id="closeModal" theme="danger" class="mr-auto" label="Dismiss" data-dismiss="modal"/>
				<x-adminlte-button onclick="{{$function}}"  theme="success" label="Accept"/>
			</x-slot>
		</form>
	</div>
	
	
</x-adminlte-modal>

