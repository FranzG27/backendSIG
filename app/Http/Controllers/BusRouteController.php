<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;
use App\Http\Requests\BusRoute\IndexBusRouteRequest;
use App\Http\Requests\BusRoute\StoreBusRouteRequest;
use App\Http\Requests\BusRoute\UpdateBusRouteRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class BusRouteController extends Controller
{

    public function index(IndexBusRouteRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<BusRoute> enviada correctamente';
        try {
            $responseArr['data'] = BusRoute::all();
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


    public function store(StoreBusRouteRequest $request)
    {
        $data = [
            'line'=>$request->line,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<BusRoute> Registro exitoso';

        try {
            DB::beginTransaction();


            $busroute = BusRoute::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo BusRoute : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $busroute;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(BusRoute $busroute)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<BusRoute> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $busroute;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(BusRoute $busroute)
    {
        //
    }

    public function update(UpdateBusRouteRequest $request, BusRoute $busroute)
    {
        $data = [
            'line'=>$request->line,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<BusRoute> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $busroute;
            $busroute->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo BusRoute : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $busroute;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(BusRoute $busroute)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<BusRoute> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$busroute->id;

            $busroute->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó BusRoute: con id:' . $id . '.'
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


    public function restore(BusRoute $busroute)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<BusRoute> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $busroute->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró BusRoute: ' . $busroute->id 
            //@@@     . ' con id:' . $busroute->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $busroute;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}