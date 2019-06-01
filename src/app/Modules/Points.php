<?php 

namespace App\Modules;

class Points {
	
	public $points;

	public function __construct() {
		$this->points = json_decode(\File::get(storage_path('app/poi.json')));
	}

	public function filterCircle($pCenter, $pRadius, $points_list = null) {
		$points_list = $points_list ?? $this->points;
		$inCircle = array();
		foreach ($points_list as $key => $value) {
			if ($this->distanceBetweenPoints($pCenter, $value) < $pRadius)
				$inCircle[] = $value;
		}
		return $inCircle;
	}

	public function filterRectangle($pNorthEast, $pSouthWest, $points_list = null) {
		$points_list = $points_list ?? $this->points;
		$inArea = array();
		foreach ($points_list as $key => $value) {
			if ($this->inBounds($value, $pNorthEast, $pSouthWest))
				$inArea[] = $value;
		}
		return $inArea;
	}

	private function distanceBetweenPoints($pReference, $pComparison) {
		$earthRadius = 6378;
		$radLatRef = deg2rad($pReference->latitude);
		$radLngRef = deg2rad($pReference->longitude);
		$radLat1 = deg2rad($pComparison->latitude);
		$radLng1 = deg2rad($pComparison->longitude);
		$distance = $earthRadius * (acos(sin($radLatRef) * sin($radLat1) + cos($radLatRef) * cos($radLat1) * cos($radLng1 - $radLngRef)));
		return $distance * 1000;
	}

	public function inBounds($pRefence, $pNorthEast, $pSouthWest) {
		if ($pRefence->longitude < $pNorthEast->longitude && $pRefence->longitude > $pSouthWest->longitude && $pRefence->latitude < $pNorthEast->latitude && $pRefence->latitude > $pSouthWest->latitude)
			return true;
		else
			return false;
	}

	public function lonToX($lon) {
		return round(268435456 + 85445659.4471 * $lon * pi() / 180);
	}

	public function latToY($lat) {
		return round(268435456 - 85445659.4471 *
			log((1 + sin($lat * pi() / 180)) /
				(1 - sin($lat * pi() / 180))) / 2);
	}

	public function distance($lat1, $lon1, $lat2, $lon2, $zoom) {
		$x1 = $this->lonToX($lon1);
		$y1 = $this->latToY($lat1);
		$x2 = $this->lonToX($lon2);
		$y2 = $this->latToY($lat2);
		return sqrt(pow(($x1-$x2),2) + pow(($y1-$y2),2)) >> (21 - $zoom);
	}

	public function cluster($markers, $distance, $zoom){
		$clustered = array();
		while (count($markers)) {
			$marker  = array_pop($markers);
			$cluster = array();
			foreach ($markers as $key => $target) {
				$pixels = $this->distance($marker->latitude, $marker->longitude,
										$target->latitude, $target->longitude,
										$zoom);
				if ($distance > $pixels) {
					unset($markers[$key]);
					$cluster[] = $target;
				}
			}
			if (count($cluster) > 0) {
				$cluster[] = $marker;
				$clustered[] = $cluster;
			} else {
				$clustered[] = $marker;
			}
		}
		return $clustered;
	}

}

