<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = [
			'title'	=> 'SI Inventory'
		];
		return view('index', $data);
	}
}
