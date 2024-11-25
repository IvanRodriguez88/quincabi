<div class="card p-2">
	<p class="m-0"><b>Name: </b> {{$client->name}}</p>
	<p class="m-0"><b>Phone: </b> {{$client->phone ?? ""}}</p>
	<p class="m-0"><b>Address: </b> {{$client->address ?? ""}}</p>
	<p class="m-0"><b>Email: </b> {{$client->email ?? ""}}</p>
</div>