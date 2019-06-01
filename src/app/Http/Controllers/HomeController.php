<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ParamsRequest;
use WebDevCraft\JsonReader\JsonReaderFactory;
use App\Modules\Points;

class HomeController extends Controller {
   
	public function index(Request $request) {
		$p = new Points();

		dd($p->points);
	}

	public function group($northeast, $southwest, $circle_center, $zoom) {
		$circle_center = explode(',', $circle_center);
		$center = new \stdClass();
		$center->latitude = $circle_center[0];
		$center->longitude = $circle_center[1];

		$northeast = explode(',', $northeast);
		$southwest = explode(',', $southwest);

		$ne = new \stdClass();
		$ne->latitude = $northeast[0];
		$ne->longitude = $northeast[1];

		$sw = new \stdClass();
		$sw->latitude = $southwest[0];
		$sw->longitude = $southwest[1];

		$points = new Points();
		if (!$points->inBounds($center, $ne, $sw)) {
			throw new Exception("Centro do círculo está fora da área de visualização do usuário", 1);
		}
		//filtra pontos possíveis na visualização do usuário
		$my_points = $points->filterRectangle($ne, $sw);

		//separa os pontos baseado no raio
		$filtered = $points->cluster($my_points, $raio, $zoom);
		return $filtered;
	}

	public function cluster($northeast, $southwest, $zoom, $radius) {
		$northeast = explode(',', $northeast);
		$southwest = explode(',', $southwest);

		$ne = new \stdClass();
		$ne->latitude = $northeast[0];
		$ne->longitude = $northeast[1];

		$sw = new \stdClass();
		$sw->latitude = $southwest[0];
		$sw->longitude = $southwest[1];

		$points = new Points();

		//filtra pontos possíveis na visualização do usuário
		$my_points = $points->filterRectangle($ne, $sw);

		//separa os pontos baseado no raio
		$filtered = $points->cluster($my_points, $radius, $zoom);

		return $filtered;
	

	}

	public function radius($circle_center, $distance) {
		$circle_center = explode(',', $circle_center);

		$center = new \stdClass();
		$center->latitude = $circle_center[0];
		$center->longitude = $circle_center[1];

		$points = new Points();
		$filtered = $points->filterCircle($center, $distance);

		return response()->json($filtered);
	}

	public function rectangle($northeast, $southwest) {
		$northeast = explode(',', $northeast);
		$southwest = explode(',', $southwest);

		$ne = new \stdClass();
		$ne->latitude = $northeast[0];
		$ne->longitude = $northeast[1];

		$sw = new \stdClass();
		$sw->latitude = $southwest[0];
		$sw->longitude = $southwest[1];

		$points = new Points();
		$filtered = $points->filterRectangle($ne, $sw);

		return response()->json($filtered);
	}
	
}
