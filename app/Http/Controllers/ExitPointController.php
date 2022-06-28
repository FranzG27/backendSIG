<?php

namespace App\Http\Controllers;

use App\Models\ExitPoint;
use App\Http\Requests\ExitPoint\IndexExitPointRequest;
use App\Http\Requests\ExitPoint\StoreExitPointRequest;
use App\Http\Requests\ExitPoint\UpdateExitPointRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class ExitPointController extends Controller
{

    public function index(IndexExitPointRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<ExitPoint> enviada correctamente';
        try {
            $responseArr['data'] = ExitPoint::BusRoute($request->bus_route_id)
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


    public function store(StoreExitPointRequest $request)
    {
        $data = [
            'lat'=>$request->lat,
            'long'=>$request->long,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<ExitPoint> Registro exitoso';

        try {
            DB::beginTransaction();


            $exitpoint = ExitPoint::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo ExitPoint : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $exitpoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(ExitPoint $exitpoint)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<ExitPoint> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $exitpoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(ExitPoint $exitpoint)
    {
        //
    }

    public function update(UpdateExitPointRequest $request, ExitPoint $exitpoint)
    {
        $data = [
            'lat'=>$request->lat,
            'long'=>$request->long,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<ExitPoint> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $exitpoint;
            $exitpoint->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo ExitPoint : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $exitpoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(ExitPoint $exitpoint)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<ExitPoint> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$exitpoint->id;

            $exitpoint->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó ExitPoint: con id:' . $id . '.'
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


    public function restore(ExitPoint $exitpoint)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<ExitPoint> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $exitpoint->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró ExitPoint: ' . $exitpoint->id 
            //@@@     . ' con id:' . $exitpoint->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $exitpoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}