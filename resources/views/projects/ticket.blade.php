<a href="{{$src}}" target="_blank">
	<div class="ticket-preview-container position-relative d-inline-block project-ticket" data-filename="{{$filename}}"  data-ticket_id="{{$ticket_id}}">
		<img src="{{$src}}" style="width: 100%; height: 100%; object-fit: cover;">
		<a class="delete-image-btn btn btn-danger btn-sm position-absolute" onclick="deleteProjectTicket('{{$filename}}', {{$ticket_id}})">X</a>
	</div>
</a>