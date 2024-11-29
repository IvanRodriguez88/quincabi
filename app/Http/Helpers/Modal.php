<?php

namespace App\Http\Helpers;
use Illuminate\Support\Facades\View;

class Modal
{
	protected $id;
    protected $title;
    protected $size;
    protected $config;

    public function __construct($id, $title, $route, $data = null, $config = [])
    {
        $this->id = $id;
		$this->title = $title;
        $this->config = $config;
        $this->route = $route;
        $this->data = $data;
    }

	/**
     * Retorna el modal para agregar o editar en un DT
     *	@param type ['add', 'edit'] 
     * 
     */
    public function getModalAddEdit($type, $idEdit = null, $nameViewFields = 'fields')
    {
		$data = $this->data ?? "";
		$action =  $this->route.".store"; //Por default tiene el action de store
		$method =  "post";
		if ($type == 'edit') {
			$action =  $this->route.".update";
		}

        return View::make('modals.modal-add-edit', [
			'id' => $this->id,
			'title' => $this->title,
			'size' => $this->config['size'] ?? "lg",
            'function' => $this->config['function'] ?? "save()",
			'action' => $action,
			'method' => $method,
			'idEdit' => $idEdit,
			'config' => $this->config,
			'fields' => view($this->route.'.'.$nameViewFields, compact('data'))->render()
		])->render();
    }

	
}