<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Custom;
use App\Http\Controllers\Controller;
use App\Models\CustomerVerifications;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use App\Utils\helper;


class CustomerController extends Controller
{
    public function index(){
        return view('admin.Customers.list');
    }
    public function getData()
    {
        $data = Customer::with('country')->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function is_verified($id){
        $customer=Customer::find($id);
        if($customer){
            $customer->email_verified=!$customer->email_verified;
            $customer->save();

            Toastr::success(__('Successfully change verified'), __('Success'));

            return redirect()->back();

        }else{
            Toastr::error(__('not found this customer'), __('Error'));
            return redirect()->back();

        }

    }
    // public function is_approve_id($id){
    //  $customer=Customer::find($id);
    //     if($customer){
    //         $customer->is_approve_id=!$customer->is_approve_id;
    //         $customer->save();

    //         Toastr::success(__('Successfully change approve_id'), __('Success'));

    //         return redirect()->back();

    //     }else{
    //         Toastr::error(__('not found this customer'), __('Error'));
    //         return redirect()->back();

    //     }
    // }

    public function verifications($customer){
     $data_all=CustomerVerifications::where('customer_id',$customer)->with('fields_country.fields')->get();
     $data = helper::transformDataByLanguage($data_all->toArray());

     return view('admin.Customers.verifications',compact('data'));

    }

    public function updateStatus($id, Request $request)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|integer'
        ]);

        // Find the item by ID and update its status
        $item = CustomerVerifications::find($id);
        if ($item) {
            $item->is_vervication = $request->input('status');
            $item->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }
    }

}
