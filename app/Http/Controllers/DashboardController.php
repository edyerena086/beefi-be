<?php

namespace MetodikaTI\Http\Controllers;

use Illuminate\Http\Request;
use MetodikaTI\Promotion;
use MetodikaTI\Http\Requests\Dashboard\CreateRequest;
use MetodikaTI\Http\Requests\Dashboard\EditRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function getHome()
    {
        $promotions = Promotion::where('end_date', '>=', Carbon::now())->get();

        return view('dashboard.home', ['promotions' => $promotions, 'centinel' => 1]);
    }

    public function getDelete($id)
    {
        $promotion = Promotion::find(base64_decode($id));

        $response = [];

        if ($promotion->delete()) {
            $response = [
                'status' => true,
                'message' => 'Se ha eliminado con éxito el elemento'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'No se ha eliminado el elemento'
            ];
        }

        return response()->json($response);
    }

    public function getCreate()
    {
        return view('dashboard.create');
    }

    public function getEdit($id) {
        $promotion = Promotion::find(base64_decode($id));

        return view('dashboard.edit', ['promotion' => $promotion]);
    }

    public function postUpdate($id, EditRequest $request)
    {
        $response = [];

        $promotion = Promotion::find(base64_decode($id));

        if ($promotion != null) {
            $promotion->name = $request->tituloDePromocion;
            $promotion->description = $request->descripcion;
            $promotion->end_date = $request->fechaDeTermino;
            $promotion->promotion_type = $request->tipoDePromocion;
            $promotion->business_name = $request->empresa;

            if ($request->hasFile('archivo')) {
                $imageName = Carbon::now()->timestamp.".".$request->file('archivo')->getClientOriginalExtension();

                if (Storage::disk('public')->putFileAs('uploads', $request->file('archivo'), $imageName)) {
                    $promotion->attachment = $imageName;
                }

                //$promotion->attachment = $request->file('archivo')->getClientOriginalName();


            }



            if ($request->has('url')) {
                $promotion->url = $request->url;
            }

            if ($promotion->save()) {
                $response = [
                    'status' => true
                ];
            } else {
                $response = [
                    'status' => false
                ];
            }
        } else {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }

    public function postStore(CreateRequest $request)
    {
        $response = [];

        $promotion = new Promotion();

        $promotion->name = $request->tituloDePromocion;
        $promotion->description = $request->descripcion;
        $promotion->end_date = $request->fechaDeTermino;
        $promotion->promotion_type = $request->tipoDePromocion;
        $promotion->extarnal_id = $this->generateExternalId();
        $promotion->business_name = $request->empresa;

        if ($request->hasFile('archivo')) {
            $imageName = Carbon::now()->timestamp.".".$request->file('archivo')->getClientOriginalExtension();

            if (Storage::disk('public')->putFileAs('uploads', $request->file('archivo'), $imageName)) {
                $promotion->attachment = $imageName;
            }

            //$promotion->attachment = $request->file('archivo')->getClientOriginalName();


        }



        if ($request->has('url')) {
            $promotion->url = $request->url;
        }

        if ($promotion->save()) {
            $response = [
                'status' => true,
                'external' => $promotion->extarnal_id
            ];
        } else {
            $response = [
                'status' => false
            ];
        }

        return response()->json($response);
    }

    private function generateExternalId()
    {
        return base64_encode(Carbon::now());
    }
}
