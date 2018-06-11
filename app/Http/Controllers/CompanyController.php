<?php

namespace MetodikaTI\Http\Controllers;

use Carbon\Carbon;
use MetodikaTI\User;
use MetodikaTI\Company;
use MetodikaTI\Category;
use MetodikaTI\CompanyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use MetodikaTI\Http\Requests\Dashboard\Company\StoreRequest;
use MetodikaTI\Http\Requests\Dashboard\Company\UpdateRequest;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name', 'ASC')->get();

        return view('company.index', ['companies' => $companies, 'centinel' => 1]);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        $categories = Category::all();

        return view('company.create', ['categories' => $categories]);
    }

    /**
     * [store description]
     * @param  StoreRequest $request [description]
     * @return [type]                [description]
     */
    public function store(StoreRequest $request)
    {
    	$response;

        $user = new User();
        $user->name = strtolower($request->nombre);
        $user->email = $request->correoElectronico;
        $user->password = bcrypt($request->password);
        $user->user_group_id = 3;

        if ($user->save()) {
            //Save company
            $company = new Company();
            $company->name = $request->nombre;
            $company->user_id = $user->id;

            //Logo
            if ($request->hasFile('logo')) {
                $imageName = Carbon::now()->timestamp.".".$request->file('logo')->getClientOriginalExtension();

                if (Storage::disk('public')->putFileAs('uploads', $request->file('logo'), $imageName)) {
                    $company->profile_picture = $imageName;
                }
            }

            //White logo
            if ($request->hasFile('logoBlanco')) {
                $imageName = Carbon::now()->timestamp."-white.".$request->file('logoBlanco')->getClientOriginalExtension();

                if (Storage::disk('public')->putFileAs('uploads', $request->file('logoBlanco'), $imageName)) {
                    $company->white_picture = $imageName;
                }
            }

            if ($company->save()) {
                //Save categories
                if ($request->has('categoria')) {

                    foreach ($request->get('categoria') as $key => $value) {
                        $category = new CompanyCategory();

                        $category->company_id = $company->id;
                        $category->category_id = $value;

                        $category->save();
                    }
                    
                }


                $response = [
                    'status' => true,
                    'message' => 'Se ha guardado con éxito la nueva empresa'
                ];
            } else {
                $user->delete();

                $response = [
                    'status' => false,
                    'message' => 'No se ha podido guardar la empresa'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'No se ha podido guardar la compañia'
            ];
        }

        /**
    	*/

    	return response()->json($response);

    }

    public function update(UpdateRequest $request, $id) {
        $response;

        $company = Company::find(base64_decode($id));

        if ($company == null) {
            $response = [
                'status' => false,
                'message' => 'El cliente ingresado no éxiste'
            ];
        } else {
            $company->name = strtolower($request->nombre);

            if ($request->hasFile('logo')) {
                $imageName = Carbon::now()->timestamp.".".$request->file('logo')->getClientOriginalExtension();

                if (Storage::disk('public')->putFileAs('uploads', $request->file('logo'), $imageName)) {
                    $company->profile_picture = $imageName;
                }
            }

            //White logo
            if ($request->hasFile('logoBlanco')) {
                $imageName = Carbon::now()->timestamp."-white.".$request->file('logoBlanco')->getClientOriginalExtension();

                if (Storage::disk('public')->putFileAs('uploads', $request->file('logoBlanco'), $imageName)) {
                    $company->white_picture = $imageName;
                }
            }

            if ($company->save()) {
                $company->user->email = $request->correoElectronico;

                if ($request->has('password')) {
                    $company->user->password = bcrypt($request->password);
                }

                if ($company->user->save()) {

                    $companyCategories = CompanyCategory::where('company_id', $company->id)->get();

                    foreach ($companyCategories as $item) {
                        $item->delete();
                    }

                    //Save categories
                    foreach ($request->get('categoria') as $key => $value) {
                        $category = new CompanyCategory();

                        $category->company_id = $company->id;
                        $category->category_id = $value;

                        $category->save();
                    }


                    $response = [
                        'status' => true,
                        'message' => 'Se ha actualizado con éxito el cliente'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'No se ha podido actualizar la información del cliente'
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha podido actualizar la información del cliente'
                ];
            }
        }

        return response()->json($response);
    }

    public function edit($id)
    {
        $company = Company::find(base64_decode($id));
        $categories = Category::all();

        if ($company == null) {
            return redirect()->back();
        } else {

            $companyCategories = CompanyCategory::where('company_id', $company->id)->get();
            $innerCC = array();

            foreach ($companyCategories as $item) {
                $innerCC[] = $item->category_id;
            }

            $innerData = [];

            foreach ($categories as $category) {
                $innerData[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'checked' => (in_array($category->id, $innerCC)) ? true : false

                ];
            }

            return view('company.edit', ['company' => $company, 'categories' => collect($innerData)]);
            
            //return collect($innerData)->chunk(2);
        }
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id){
    	$response;

    	$company = Company::find(base64_decode($id));

    	if ($company == null) {
    		$response = [
    			'status' => false,
    			'message' => 'La compañía ingresada no existe'
    		];
    	} else {
            $user = User::find($company->user_id);

            if ($user != null) {
                if ($user->delete()) {

                    if ($company->delete()) {
                        $response = [
                            'status' => true,
                            'message' => 'Se ha eliminado con éxito la empresa.'
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'message' => 'No se ha podido eliminar la empresa.'
                        ];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'No se ha podido eliminar la empresa.'
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha podido eliminar la empresa.'
                ];
            }

            /*$userId = $company->user_id;
    		if ($company->delete()) {
                //Delete user
                $user = User::find($userId);

                if ($user != null) {
                    $user->delete();
                }

    			$response = [
    				'status' => true,
    				'message' => 'Se ha eliminado con éxito la empresa.'
    			];
    		} else {
    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido eliminar la empresa.'
    			];
    		}*/
    	}

    	return response()->json($response);
    }
}
