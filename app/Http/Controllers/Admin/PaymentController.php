<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\paymentStoreRequest;
use App\Http\Requests\paymentUpdateRequest;

class PaymentController extends Controller
{
    //
          ///start types
          public function index()
          {

              return view('admin.payments.list');
          }
          public function getData()
          {
              $data = Payments::all();

              return response()->json([
                  'data' => $data,
                  'message' => 'found data'
              ]);
          }

          public function store(paymentStoreRequest $request)
          {
              try {
                  $requestData = $request->all();


                  Payments::create($requestData);


                  Toastr::success(__('Payment Created Successfully'), __('Success'));

                  return redirect()->back();
              } catch (\Throwable $th) {
                  Toastr::error(__('Try Again'), __('Error'));
                  return redirect()->back();
              }
          }

          public function update(paymentUpdateRequest $request)
          {
              try {
                  // Find the category by ID
                  $Currancy = Payments::findOrFail($request->input('id'));

                  // Get the validated data, excluding 'id'
                  $requestData = $request->except('id');

                  // Update the Peroid with the validated data
                  $Currancy->update([
                    'name'=>$request->name,
                    'feas'=>$request->feas,
                    'persage'=>$request->persage
                  ]);

                  // Display success message and redirect to index
                  Toastr::success(__('Payment Updated Successfully'), __('Success'));
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
                  'id' => 'required|exists:payments,id'
              ]);


                  $data = Payments::where('id', '=', $dataval['id'])->first();
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
