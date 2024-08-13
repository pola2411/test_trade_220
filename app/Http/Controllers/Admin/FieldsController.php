<?php

namespace App\Http\Controllers\Admin;

use App\Utils\helper;
use App\Models\Fields;
use App\Models\FieldsType;
use Illuminate\Http\Request;
use App\Models\FieldsCountry;
use App\Http\Controllers\Controller;
use App\Http\Requests\fieldsCountryStoreRequest;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\fieldsStoreRequest;
use App\Http\Requests\FieldsUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FieldsController extends Controller
{

    public function index(){
        $types_inputs=FieldsType::get()->toArray();
        $types = helper::transformDataByLanguage($types_inputs);

        return view('admin.fields.index',compact('types'));
    }
    public function datatable(){
        $data = Fields::with('type')->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }


    public function store(fieldsStoreRequest $request)
    {
        try {
            $requestData = $request->all();


            Fields::create($requestData);


            Toastr::success(__('Field Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function update(FieldsUpdateRequest $request)
    {
        try {
            // Find the category by ID
            $Currancy = Fields::findOrFail($request->input('id'));

            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Currancy->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('Field Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function countries(){
        return view('admin.fields.countries');
    }
    public function countries_fields($id){
        $fields_data=Fields::get();
        $fields = helper::transformDataByLanguage($fields_data->toArray());

        return view('admin.fields.fields_country',compact('id','fields'));
    }
    public function countries_fields_datatable($id){
        $data = FieldsCountry::where('country_id',$id)->with('fields','country')->get();
        $types = helper::transformDataByLanguage($data->toArray());
        return response()->json([
            'data' => $types,
            'message' => 'found data'
        ]);

    }



    public function status(Request $request)
    {
        $dataval = $request->validate([
            'id' => 'required|exists:fields_countries,id'
        ]);


            $data = FieldsCountry::where('id', '=', $dataval['id'])->first();
            if ($data) {

                $data->status = !$data->status;
                $data->update();
                $successMessage = $data->status == 1 ?
                    __('validation_custom.status_update_active') :
                    __('validation_custom.status_update_inactive');

                return $successMessage;

        }else{
            return response()->json(['status' => '404']);

        }

    }

    public function store_fields_country(fieldsCountryStoreRequest $request)
    {
        try {
            $requestData = $request->all();


            FieldsCountry::create($requestData);


            Toastr::success(__('Field Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


}
