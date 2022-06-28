<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Http\Requests\Bus\IndexBusRequest;
use App\Http\Requests\Bus\StoreBusRequest;
use App\Http\Requests\Bus\UpdateBusRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{

    public function index(IndexBusRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Bus> enviada correctamente';
        try {
            $responseArr['data'] = Bus::User($request->user_id)
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


    public function store(StoreBusRequest $request)
    {
        $data = [
            'placa'=>$request->placa,
            'modelo'=>$request->modelo,
            'cantidad_asientos'=>$request->cantidad_asientos,
            'fecha_asignacion'=>$request->fecha_asignacion,
            'fecha_baja'=>$request->fecha_baja,
            'numero_interno'=>$request->numero_interno,
            'esta_en_recorrido'=>$request->esta_en_recorrido,
            'user_id'=>$request->user_id,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Bus> Registro exitoso';

        try {
            DB::beginTransaction();


            $bus = Bus::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Bus : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $bus;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Bus $bus)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Bus> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $bus;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Bus $bus)
    {
        //
    }

    public function update(UpdateBusRequest $request, Bus $bus)
    {
        $data = [
            'placa'=>$request->placa,
            'modelo'=>$request->modelo,
            'cantidad_asientos'=>$request->cantidad_asientos,
            'fecha_asignacion'=>$request->fecha_asignacion,
            'fecha_baja'=>$request->fecha_baja,
            'numero_interno'=>$request->numero_interno,
            'esta_en_recorrido'=>$request->esta_en_recorrido,
            'user_id'=>$request->user_id,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Bus> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $bus;
            $bus->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Bus : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $bus;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Bus $bus)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Bus> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$bus->id;

            $bus->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Bus: con id:' . $id . '.'
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


    public function restore(Bus $bus)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Bus> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $bus->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Bus: ' . $bus->id 
            //@@@     . ' con id:' . $bus->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $bus;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}