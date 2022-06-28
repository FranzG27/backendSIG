<?php

namespace App\Http\Controllers;

use App\Models\Chofer;
use App\Http\Requests\Chofer\IndexChoferRequest;
use App\Http\Requests\Chofer\StoreChoferRequest;
use App\Http\Requests\Chofer\UpdateChoferRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class ChoferController extends Controller
{

    public function index(IndexChoferRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Chofer> enviada correctamente';
        try {
            $responseArr['data'] = Chofer::User($request->user_id)
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


    public function store(StoreChoferRequest $request)
    {
        $data = [
            'ci'=>$request->ci,
            'fecha_nacimiento'=>$request->fecha_nacimiento,
            'sexo'=>$request->sexo,
            'telefono'=>$request->telefono,
            'categoria_licencia'=>$request->categoria_licencia,
            'foto'=>'',
            'user_id'=>$request->user_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Chofer> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = Storage::disk('public')->put('foto', $request->foto);
            }

            $chofer = Chofer::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Chofer : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $chofer;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            if (!is_null($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Chofer $chofer)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Chofer> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $chofer;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Chofer $chofer)
    {
        //
    }

    public function update(UpdateChoferRequest $request, Chofer $chofer)
    {
        $data = [
            'ci'=>$request->ci,
            'fecha_nacimiento'=>$request->fecha_nacimiento,
            'sexo'=>$request->sexo,
            'telefono'=>$request->telefono,
            'categoria_licencia'=>$request->categoria_licencia,
            'foto'=>$chofer->foto,
            'user_id'=>$request->user_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Chofer> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                if (!is_null($chofer->foto)) {
                    Storage::disk('public')->delete($chofer->foto);
                }
                $data['foto'] = Storage::disk('public')->put('foto', $request->foto);
            }


            $before = $chofer;
            $chofer->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Chofer : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $chofer;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            if (!is_null($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Chofer $chofer)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Chofer> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$chofer->id;
            if (!is_null($chofer->foto)) {
                Storage::disk('public')->delete($chofer->foto);
            }

            $chofer->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Chofer: con id:' . $id . '.'
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


    public function restore(Chofer $chofer)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Chofer> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $chofer->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Chofer: ' . $chofer->id 
            //@@@     . ' con id:' . $chofer->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $chofer;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}