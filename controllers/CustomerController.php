<?php

namespace App\Http\Controllers\Admin;
use App\FoodItems;
use App\User;
use App\Notification;
use App\Helpers\Helper;
use App\Traits\Customers;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CustomerController extends Controller
{
    use Customers;

    /*
     * @method      : index
     * @params      : request
     * @created_date: 18-04-2019
     * @developer   : Varun
     * @purpose     : To show list of customers
     * @return      :
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Input::get('search')) {
                $keyword = Input::get('search');
                $customers = $this->getSearchCustomer($keyword);
            } else {
                $customers = $this->getSortCustomer();
            }
            $view = 'admin.customers.paginate';
        } else {
            $customers = $this->getLatestCustomer();
            $view = 'admin.customers.index';
        }
        $title = 'customer';
        return view($view, compact('customers','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /*
     * @method      : show
     * @params      : encryptId
     * @created_date: 02-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To reset password
     * @return      :
     */
    public function show($encryptId)
    {
        try {
            $id = Helper::decryptDataId($encryptId);
            $customer = User::where('id', $id)->firstOrFail();
            $title = 'customer';
            return view('admin.customers.reset_password',compact('customer','title'));
        }catch(\Exception $e){
            return redirect('admin/customer')->withError($e->getMessage());
        }
    }

    /*
     * @method      : edit
     * @params      : encryptId
     * @created_date: 02-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To view customers
     */
    public function edit(Request $request, $encryptId)
    {  
        $id = Helper::decryptDataId($encryptId);
        $customer = User::where('id',$id)->where('type',2)->firstOrFail();
        if($customer){
            if(isset($request->notification_status) && $request->notification_status=='seen' && isset($request->id)){
                $notID = Helper::decryptDataId($request->id);
                $res = Notification::whereId($notID)->update(['status'=>'1']);
            } 
        }
        $title = 'customer';
        return view('admin.customers.edit',compact('customer','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /*
     * @method      : destroy
     * @params      : request, encryptId
     * @created_date: 02-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To delete customer
     */
    public function destroy(Request $request, $encryptId)
    {
        try {
            $id = Helper::decryptDataId($encryptId);
            $food = User::where('id', $id)->firstOrFail();
            $message = !empty($food) ? 'Customer has been deleted successfully.' : 'Data not found';
            if ($request->ajax()) {
                return $this->ajaxSoftDeletion('App\User', $id, '/admin/customer', $message);
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return new jsonResponse(['status' => 0, 'message' => $e->getMessage()]);
            } else {
                return redirect('admin/customer')->withError($e->getMessage());
            }
        }
        return redirect('admin/customer')->withError('There is something wrong. Please try again later.');
    }

    /*
     * @method      : customerFood
     * @params      : encryptId
     * @created_date: 07-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To view customer's food
     */
    public function customerFood($encryptId)
    {
        $id = Helper::decryptDataId($encryptId);
        $customers = FoodItems::where('user_id',$id)->get();
        $title = 'customer';
        return view('admin.customers.view_customer_food',compact('customers','title'));
    }

    /*
     * @method      : status
     * @params      : encryptId
     * @created_date: 02-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To change the customers status
     */
    public function status($encryptId)
    {
        try{
            $id = Helper::decryptDataId($encryptId);
            $customer = User::where('id',$id)->firstOrFail();
            $current_status = !empty($customer->status) ? 0 : 1;
            $title = !empty($customer->status) ? 'Activate' : 'Deactivate';
            $message = !empty($customer->status) ? 'Customer status has been changed to deactivated.' : 'Customer status has been changed to activated.';
            if($customer->status == 0){
                $status = 1;
            }else{
                $status = 0;
            }
            $requestData['status'] = $status;
            User::where('id',$id)->where('type',2)->update($requestData);
            return new JsonResponse(['status' => 1,'message' => $message, 'current_status' => $current_status, 'title' => $title]);
        } catch (\Execption $e) {
            return new JsonResponse(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /*
     * @method      : resetPassword
     * @params      : encryptId
     * @created_date: 02-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To reset the customer password
     */
    public function resetPassword(Request $request, $encryptId)
    {
        $this->ValidationCheck(['password' => 'required|min:8']);
        try {
            $id = Helper::decryptDataId($encryptId);
            $data = [
              'password'  =>  Hash::make($request->password),
            ];
            User::where('id',$id)->update($data);
            return redirect('admin/customer')->withSuccess('Password has been changed successfully.');
        }catch(\Exception $e){
            return redirect('admin/customer')->withError($e->getMessage());
        }
    }

    /*
     * @method      : exportUser
     * @params      : $keyword
     * @created_date: 02-05-2019 (dd-mm-yyyy)
     * @developer   : Varun
     * @purpose     : To export customer in excel file
     */
    public function exportUser($keyword=null)
    {
        try{
            $keyword = strval($keyword);
            $fileName = 'customers'.time().'.xlsx';
            Excel::store(new UsersExport($keyword), 'public/'.$fileName);
            $url = env('APP_PUBLIC_PATH').'storage/'.$fileName;
            return response(['status'=>1, 'url'=> $url, 'file_name' => $fileName]);
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return response(['status'=>0, 'url'=>url('/admin/customer')]);
        }
    }
}
