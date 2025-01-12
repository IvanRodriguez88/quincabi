<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\ProjectWorker;
use Illuminate\Support\Facades\DB;

class ReportByWorkerController extends Controller
{
    public function index()
	{
		$heads = [
			'Worker',
			'Worked Hours',
			'Amount'
		];

		$routeResource = "report_by_workers";
		$workers = Worker::where("is_active", 1)->get();
		
		$workersEarnings = ProjectWorker::select(
			'worker_id', 
			DB::raw('SUM(hourly_pay * worked_hours) as total_earnings'),
			DB::raw('SUM(worked_hours) as worked_hours')
		)
		->with('worker') // Asumiendo que tienes una relación 'worker' en tu modelo
		->groupBy('worker_id')
		->get();

		$data = $workersEarnings->map(function ($projectWorker) {
			return [
				'worker' => $projectWorker->worker->name, // Ajusta según el campo de nombre en tu modelo Worker
				'worked_hours' => formatNumber($projectWorker->worked_hours), // Ajusta según el campo de nombre en tu modelo Worker
				'amount' => formatNumber($projectWorker->total_earnings),
			];
		});

		return view("reports.report_by_workers", compact("data", "routeResource",  "heads", "workers"));
	}

	public function filterDT(Request $request)
	{
		$startDate = $request->input('start_date'); // Fecha inicial por defecto
		$endDate = $request->input('end_date'); // Fecha final por defecto

		$startDate = $startDate ?? '2000-01-01'; // Si no se proporciona, usar una fecha muy antigua
		$endDate = $endDate ?? now()->toDateString(); // Si no se proporciona, usar hoy

		$worker_id = $request->input('worker_id'); // Fecha final por defecto

		$query = ProjectWorker::select(
			'worker_id', 
			DB::raw('SUM(hourly_pay * worked_hours) as total_earnings'),
			DB::raw('SUM(worked_hours) as worked_hours')
		)
		->with('worker')
		->whereBetween('date', [$startDate, $endDate])
		->groupBy('worker_id');

		if ($worker_id != 0) {
			$query->where('worker_id', $worker_id);
		}

		if ($worker_id != 0) {
			$query->where('worker_id', $worker_id);
		}

		$results = $query->get();
		

		$data = $results->map(function ($projectWorker) {
			return [
				$projectWorker->worker->name,
				formatNumber($projectWorker->worked_hours), // Ajusta según el campo de nombre en tu modelo Worker
				"$".formatNumber($projectWorker->total_earnings),
			];
		});

		return response()->json(['data' => $data]);
	}

}
