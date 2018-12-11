<?php

namespace Candidatos\Http\Controllers;

use Illuminate\Http\Request;
use GeneaLabs\LaravelMaps\Facades\Map;
use Candidatos\Peticion;
use Candidatos\Candidato;

class GmapsController extends Controller {

    public function index(Request $request) {
        $config = array();
        /* $config['center'] = 'auto';
          $config['onboundschanged'] = 'if (!centreGot) {
          var mapCentre = map.getCenter();
          marker_0.setOptions({
          position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
          });
          }
          centreGot = true;';

          app('map')->initialize($config);

          // set up the marker ready for positioning
          // once we know the users location
          $marker = array();
          app('map')->add_marker($marker);

          $map = app('map')->create_map(); */
        //echo "<html><head><script type="text/javascript">var centreGot = false;</script>" . $map['js'] . "</head><body>" . $map['html'] . "</body></html>";
        //return view('mapas.index', compact('map'));

        $candidatos = Candidato::getCandidatosGridMapas($request);
        $peticiones = Peticion::getPeticionesGridMapas($request);

        return view('mapas.index', compact('candidatos', 'peticiones'));
    }


    public function index2($map) {
        app()
                ->make('\App\Http\Controllers\GmapsController')
                ->callAction($map, $parameters = array());

        $map = Map::create_map();
        return view('mapas.index')->with('map', $map);
    }

}
