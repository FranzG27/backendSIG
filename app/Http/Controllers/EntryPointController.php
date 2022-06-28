<?php

namespace App\Http\Controllers;

use App\Models\EntryPoint;
use App\Http\Requests\EntryPoint\IndexEntryPointRequest;
use App\Http\Requests\EntryPoint\StoreEntryPointRequest;
use App\Http\Requests\EntryPoint\UpdateEntryPointRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class EntryPointController extends Controller
{

    public function index(IndexEntryPointRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<EntryPoint> enviada correctamente';
        try {
            $responseArr['data'] = EntryPoint::BusRoute($request->bus_route_id)
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


    public function store(StoreEntryPointRequest $request)
    {
        $data = [
            'lat'=>$request->lat,
            'long'=>$request->long,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<EntryPoint> Registro exitoso';

        try {
            DB::beginTransaction();


            $entrypoint = EntryPoint::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo EntryPoint : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $entrypoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();


            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(EntryPoint $entrypoint)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<EntryPoint> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $entrypoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(EntryPoint $entrypoint)
    {
        //
    }

    public function update(UpdateEntryPointRequest $request, EntryPoint $entrypoint)
    {
        $data = [
            'lat'=>$request->lat,
            'long'=>$request->long,
            'bus_route_id'=>$request->bus_route_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<EntryPoint> Modificado correctamente';
        try {
            DB::beginTransaction();



            $before = $entrypoint;
            $entrypoint->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo EntryPoint : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $entrypoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(EntryPoint $entrypoint)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<EntryPoint> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$entrypoint->id;

            $entrypoint->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó EntryPoint: con id:' . $id . '.'
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


    public function restore(EntryPoint $entrypoint)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<EntryPoint> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $entrypoint->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró EntryPoint: ' . $entrypoint->id 
            //@@@     . ' con id:' . $entrypoint->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $entrypoint;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}