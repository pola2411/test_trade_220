<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Account;
use App\Models\Withdrawn;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\statusWithdrawn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\AddToWalitByAdminRequest;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AccountController extends Controller
{
    //
    public function index()
    {
        return view('admin.account.index');
    }
    public function getData()
    {
        $data = Account::with('customer','currancy')->where('type',0)->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function Withdrawals($account_id){
        $lang=App::getLocale();

        $status=statusWithdrawn::select('id','title_' . $lang . ' as title')->get();

        return view('admin.account.Withdrawals',compact('account_id','status'));

    }

    public function withdrawals_data($account_id){
        $lang=App::getLocale();
        $data = Withdrawn::where('account_id', $account_id)
        ->with([
            'status'=> function ($query) use ($lang) {
                $query->select('id', DB::raw('title_' . $lang . ' as title'));
            },
            'account_bank.bank' => function ($query) use ($lang) {
                $query->select('id', DB::raw('title_' . $lang . ' as title'));
            },
            'approved_by' => function ($query) {
                $query->select('id', 'email'); // Always include the primary key
            }
        ])->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }
    public function update_status(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'id' => 'required|integer|exists:withdrawns,id',
            'status_id' => 'required|integer|exists:status_withdrawns,id', // Assuming you have a `statuses` table
        ]);

        try {
            // Find the withdrawal record
            $data = Withdrawn::find($request->id);

            if ($data) {
                // Check if the status requires an update to the account balance
                if ($request->status_id == 3) {
                    $account = Account::find($data->account_id);
                    if ($account) {
                        // Update account balance
                        $account->balance += $data->value + $data->feas;
                        $account->save(); // Use save() instead of update() for better practice
                        $tans=new Transactions();
                        $tans->value=$data->value + $data->feas;
                        $tans->account_id=$data->account_id;
                        $tans->transactions_status_id=5;
                        $tans->related_id=$request->id;
                        $tans->relatied_model="Withdrawn";
                        $tans->save();

                    } else {
                        return response()->json(['message' => 'Account not found.'], 404);
                    }
                }

                // Update withdrawal status and approved_by fields
                $data->status_id = $request->status_id;
                $data->approved_by = auth()->user()->id;
                $data->save(); // Save changes to the withdrawal record

                return response()->json(['message' => 'Status updated successfully.'], 200);
            } else {
                return response()->json(['message' => 'Withdrawal record not found.'], 404);
            }
        } catch (\Throwable $th) {
            // Log the error for debugging
            \Log::error('Error updating status: '.$th->getMessage());

            return response()->json(['message' => 'An error occurred while updating the status.'], 500);
        }
    }

    public function add_to_walit_by_admin(AddToWalitByAdminRequest $AddToWalitByAdminRequest)
    {
        $requestData = $AddToWalitByAdminRequest->all();

        DB::beginTransaction();

        try {
            // Create a new transaction record
            $tans = new Transactions();
            $tans->value = $requestData['balance'];
            $tans->account_id = $requestData['account_id'];
            $tans->transactions_status_id = 1;
            $tans->related_id = auth()->user()->id;
            $tans->relatied_model = "User";
            $tans->save();

            // Find the account and update its balance
            $account = Account::findOrFail($requestData['account_id']);
            $account->balance += $requestData['balance'];
            $account->save();

            // Commit the transaction
            DB::commit();

            // Return success response for AJAX
            return response()->json([
                'success' => true,
                'message' => __('Add amount to balance for account ID ' . $requestData['account_id'] . ' successfully')
            ]);

        } catch (ModelNotFoundException $e) {
            // Rollback the transaction if the model is not found
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('Account not found')
            ], 404);

        } catch (\Exception $e) {
            // Rollback the transaction for any other exceptions
            DB::rollBack();
            \Log::error('Error adding to wallet: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('An error occurred while adding to the balance')
            ], 500);
        }
    }




    /// demo
    public function demo()
    {
        return view('admin.account.demo');
    }
    public function getData_demo()
    {
        $data = Account::with('customer','currancy')->where('type',1)->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function status(Request $request)
    {
        $dataval = $request->validate([
            'id' => 'required|exists:accounts,id'
        ]);


            $data = Account::where('id', '=', $dataval['id'])->first();
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
