<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\Location\IndexLocationRequest;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function index(IndexLocationRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Location> enviada correctamente';
        try {
            $responseArr['data'] = Location::Bus($request->bus_id)
                                   ->BusRoute($request->bus_route_id)
                                   ->get();
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function create()
    {
        //
    }


    public function store(StoreLocationRequest $request)
    {
        $data = [
            'lat'=>$request->lat,
            'long'=>$request->long,
            'bus_id'=>$request->bus_id,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Location> Registro exitoso';

        try {
            DB::beginTransaction();


            $location = Location::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Location : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $location;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Location $location)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Location> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $location;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Location $location)
    {
        //
    }

    public function update(UpdateLocationRequest $request, Location $location)
    {
        $data = [
            'lat'=>$request->lat,
            'long'=>$request->long,
            'bus_id'=>$request->bus_id,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Location> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $location;
            $location->update($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ $description_before = '';
            //@@@ foreach ($before as $b) {
            //@@@     $index = array_search($b, $before);
            //@@@     $description_before = $description_before .   $index . " : " . $b . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Location : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $location;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Location $location)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Location> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$location->id;

            $location->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Location: con id:' . $id . '.'
            //@@@ ]);

            DB::commit();
            
            $responseArr['data'] = [];
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function restore(Location $location)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Location> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $location->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Location: ' . $location->id 
            //@@@     . ' con id:' . $location->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $location;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}