<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;

class BanksController extends Controller
{
    //
          ///start types
          public function index()
          {

              return view('admin.banks.index');
          }
          public function getData()
          {
              $data = Banks::all();

              return response()->json([
                  'data' => $data,
                  'message' => 'found data'
              ]);
          }

          public function store(BankStoreRequest $request)
          {
              try {
                  $requestData = $request->all();


                  Banks::create($requestData);


                  Toastr::success(__('Bank Created Successfully'), __('Success'));

                  return redirect()->back();
              } catch (\Throwable $th) {
                  Toastr::error(__('Try Again'), __('Error'));
                  return redirect()->back();
              }
          }

          public function update(BankUpdateRequest $request)
          {
              try {
                  // Find the category by ID
                  $Currancy = Banks::findOrFail($request->input('id'));

                  // Get the validated data, excluding 'id'
                  $requestData = $request->except('id');

                  // Update the Peroid with the validated data
                  $Currancy->update($requestData);

                  // Display success message and redirect to index
                  Toastr::success(__('Bank Updated Successfully'), __('Success'));
                  return redirect()->back();
              } catch (\Throwable $th) {
                  // Display error message and redirect back
                  Toastr::error(__('Try Again'), __('Error'));
                  return redirect()->back();
              }
          }

          public function status(Request $request)
          {
              $dataval = $request->validate([
                  'id' => 'required|exists:banks,id'
              ]);


                  $data = Banks::where('id', '=', $dataval['id'])->first();
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
}
