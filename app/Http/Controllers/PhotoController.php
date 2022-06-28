<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\Photo\IndexPhotoRequest;
use App\Http\Requests\Photo\StorePhotoRequest;
use App\Http\Requests\Photo\UpdatePhotoRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use \Exception;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{

    public function index(IndexPhotoRequest $request)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = 'Lista<Photo> enviada correctamente';
        try {
            $responseArr['data'] = Photo::Bus($request->bus_id)
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


    public function store(StorePhotoRequest $request)
    {
        $data = [
            'image'=>'',
            'bus_id'=>$request->bus_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Photo> Registro exitoso';

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }

            $photo = Photo::create($data);

            //@@@ $description = '';
            //@@@ foreach ($data as $d) {
            //@@@     $index = array_search($d, $data);
            //@@@     $description = $description .   $index . " : " . $d . ",\n";
            //@@@ };
            //@@@
            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' creo Photo : \n'.
            //@@@     '[ '.$description.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $photo;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();

            if (!is_null($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }


    public function show(Photo $photo)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Photo> ¡Enviado correctamente!';
        try {
            $responseArr['data'] = $photo;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function edit(Photo $photo)
    {
        //
    }

    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        $data = [
            'image'=>$photo->image,
            'bus_id'=>$request->bus_id,

        ];

        $responseArr['data'] = [];
        $responseArr['message'] = '<Photo> Modificado correctamente';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (!is_null($photo->image)) {
                    Storage::disk('public')->delete($photo->image);
                }
                $data['image'] = Storage::disk('public')->put('image', $request->image);
            }


            $before = $photo;
            $photo->update($data);

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
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' actualizo Photo : \n'.
            //@@@     '[ '.$description.'] \n con:  ['.$description_before.' ]'
            //@@@ ]);

            DB::commit();

            $responseArr['data'] = $photo;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            if (!is_null($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            $message = $e;
            $responseArr['data'] = [];
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }

    public function destroy(Photo $photo)
    {
        $responseArr['data'] = [];
        $responseArr['message'] = '<Photo> Eliminado correctamente';
        try {
            DB::beginTransaction();

            $id=$photo->id;
            if (!is_null($photo->image)) {
                Storage::disk('public')->delete($photo->image);
            }

            $photo->delete();


            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' eliminó Photo: con id:' . $id . '.'
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


    public function restore(Photo $photo)
    {

        $responseArr['data'] = [];
        $responseArr['message'] = '<Photo> Restaurado correctamente';
        try {
            DB::beginTransaction();

            $photo->restore();

            //@@@ Binnacle::create([
            //@@@     'user_id' => auth()->user()->id,
            //@@@     'description' => 'El usuario ' . auth()->user()->name . ' restauró Photo: ' . $photo->id 
            //@@@     . ' con id:' . $photo->id . '.'
            //@@@ ]);
            DB::commit();

            $responseArr['data'] = $photo;
            return response()->json($responseArr, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $e;
            $responseArr['message'] = $message;
            return response()->json($responseArr, Response::HTTP_GATEWAY_TIMEOUT);
        }
    }
}