<div class="row">
    <input type="hidden" name="project_id" value="{{$data['project']->id}}">

    @if (isset($data["project_partner"]))
     <x-adminlte-select id="partner_id" name="partner_id" label="Partner" required fgroup-class="col-md-4">
            <option disabled>Select a partner...</option>
            @foreach ($data["partners"] as $partner)
                <option value="{{$partner->id}}" {{$partner->id == $data["project_partner"]->id ? 'selected' : ''}}>{{$partner->name}}</option>
            @endforeach
        </x-adminlte-select>
    @else
        <x-adminlte-select id="partner_id" name="partner_id" label="Partner" required fgroup-class="col-md-4">
            <option disabled selected>Select a partner...</option>
            @foreach ($data["partners"] as $partner)
                <option value="{{$partner->id}}">{{$partner->name}}</option>
            @endforeach
        </x-adminlte-select>
    @endif
  

    <x-adminlte-input 
        value="{{($data['project_partner']->percentage) ?? ''}}" 
        name="percentage" 
        label="Percentage" 
        placeholder="Precentage"
        fgroup-class="col-md-4" 
        disable-feedback
        type="number"
    />
</div>

<script>
    
	$("#partner_id").on("change", function(){
        $.ajax({
            url: `${getBaseUrl()}/partners/getpartner/${$(this).val()}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                console.log(response);
                
                $("#percentage").val(response.percentage)
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    })
</script>