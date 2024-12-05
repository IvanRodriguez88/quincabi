@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
    <div class="card">
     <div id="calendar"></div>
    </div>
    <div id="addEditModal">
		{{-- Aquí se llena el modal por ajax --}}
	</div>
  
</div>

@stop

@section('css')
	@vite(['resources/css/app.css'])
    @vite(['resources/sass/calendar.scss'])

    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
@stop

@section('js')
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js'])

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script> 
       document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($events),
                eventClick: function (info) {
                    if (info.event.url) {
                        window.location = (info.event.url); // Abrir en una nueva pestaña
                        info.jsEvent.preventDefault(); // Prevenir el comportamiento por defecto del navegador
                    }
                },
                dateClick: function(info) {
                    // Prellenar la fecha seleccionada en el formulario
                    
                    
                    let url = `${getBaseUrl()}/projects/getaddeditmodal`
                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {type: 'add'},
                        success: function (response) {
                            $("#addEditModal").empty().append(response)
                            $("#projectsModal").modal('show')
                            document.getElementById('initial_date').value = info.dateStr;
                            document.getElementById('end_date').value = info.dateStr;
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
                        },
                    });
                }
            });
            calendar.render();

            window.save = () => {
                const formProjects = $("#projectsModal-form")
                const action = formProjects.attr('action')
                const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
                
                $.ajax({
                    type: method,
                    url: action,
                    data: formProjects.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log(response);
                        $("#closeModal").trigger('click')
                        
                        if (method == "POST") {
                            toastr.success(`The project ${response.project.name} has been created successfully`, 'Project created')
                            setTimeout(() => {
                                window.location = `${getBaseUrl()}/projects/${response.project.id}/edit`
                            }, 1000);
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        $("#error-messages").hide();
                        $("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
                        $("#error-messages").slideDown("fast");
                    },
                });
            }
        });

    </script>
@stop