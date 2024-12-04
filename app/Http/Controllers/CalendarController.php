<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $events = [];
 
        $projects = Project::all();
 
        foreach ($projects as $project) {
            $events[] = [
                'title' => $project->name,
                'start' => $project->initial_date,
                'end' => Carbon::parse($project->end_date)->addDay()->format('Y-m-d'), // Sumar un día a la fecha final
                'url' => route('projects.edit', $project->id), // Ajusta la ruta según tu configuración

            ];
        }

        return view('calendar.index', compact("events"));
    }
}
