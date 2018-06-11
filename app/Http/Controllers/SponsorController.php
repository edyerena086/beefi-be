<?php

namespace MetodikaTI\Http\Controllers;

use Carbon\Carbon;
use MetodikaTI\Sponsor;
use MetodikaTI\Company;
use MetodikaTI\Category;
use MetodikaTI\SponsorCategory;
use MetodikaTI\SponsorCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MetodikaTI\Http\Requests\Dashboard\Sponsor\StoreRequest;
use MetodikaTI\Http\Requests\Dashboard\Sponsor\UpdateRequest;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::orderBy('created_at', 'DESC')->get();

        return view('sponsor.index', ['sponsors' => $sponsors, 'counter' => $sponsors->count(), 'centinel' => 1]);
    }

    public function create()
    {
        $companies = Company::all();

        $categories = Category::all();

        return view('sponsor.create', ['companies' => $companies, 'categories' => $categories]);
    }

    public function store(StoreRequest $request)
    {
    	$response;

    	$sponsor = new Sponsor();

    	$imageName = Carbon::now()->timestamp.".".$request->file('imagen')->getClientOriginalExtension();

    	if (Storage::disk('public')->putFileAs('uploads', $request->file('imagen'), $imageName)) {
            $sponsor->sponsor_ad = $imageName;
            $sponsor->company_name = $request->empresa;

            if ($sponsor->save()) {
                //Save categories
                if ($request->has('categoria')) {

                    foreach ($request->get('categoria') as $key => $value) {
                        $category = new SponsorCategory();

                        $category->sponsor_id = $sponsor->id;
                        $category->category_id = $value;

                        $category->save();
                    }

                }

                if ($request->has('compania')) {

                    //Save companies
                    foreach ($request->get('compania') as $key => $value) {
                        $company = new SponsorCompany();

                        $company->sponsor_id = $sponsor->id;
                        $company->company_id = $value;

                        $company->save();
                    }

                }

            	$response = [
            		'status' => true,
            		'message' => 'Se ha guardado con éxito el sponsor.'
            	];
            } else {
            	$response = [
	        		'status' => false,
	        		'message' => 'No se ha podido guardar el sponsor.'
	        	];
            }
        } else {
        	$response = [
        		'status' => false,
        		'message' => 'No se ha podido guardar el sponsor.'
        	];
        }

        return response()->json($response);
    }

    public function update(UpdateRequest $request, $id)
    {
    	$response;

    	$sponsor = Sponsor::find(base64_decode($id));

    	if ($sponsor != null) {
    		$sponsor->company_name = $request->empresa;

    		if ($request->hasFile('imagen')) {
    			$imageName = Carbon::now()->timestamp.".".$request->file('imagen')->getClientOriginalExtension();

    			if (Storage::disk('public')->putFileAs('uploads/sponsor', $request->file('imagen'), $imageName)) {
		            $sponsor->sponsor_ad = $imageName;

		            if ($sponsor->save()) {
		            	$response = [
		            		'status' => true,
		            		'message' => 'Se ha guardado con éxito el sponsor.'
		            	];
		            } else {
		            	$response = [
			        		'status' => false,
			        		'message' => 'No se ha podido guardar el sponsor.'
			        	];
		            }
		        } else {
		        	$response = [
		        		'status' => false,
		        		'message' => 'No se ha podido guardar el sponsor.'
		        	];
		        }
    		} else {
    			if ($sponsor->save()) {
    				$response = [
		            		'status' => true,
		            		'message' => 'Se ha guardado con éxito el sponsor.'
		            	];
    			} else {
    				$response = [
		        		'status' => false,
		        		'message' => 'No se ha podido guardar el sponsor.'
		        	];
    			}
    		}
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'El sponsor ingresado no se encuentra registrado en el sistema.'
    		];
    	}

    	return response()->json($response);
    }

    public function delete($id)
    {
    	$response;

    	$sponsor = Sponsor::find(base64_decode($id));

    	if ($sponsor != null) {
    		if ($sponsor->delete()) {
    			$response = [
    				'status' => true,
    				'message' => 'Se ha eliminado con éxito el sponsor'
    			];
    		} else {
    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido eliminar el sponsor'
    			];
    		}
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'El sponsor ingresado no se encuentra en el sistema.'
    		];
    	}

    	return response()->json($response);
    }
}
