<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use App\Models\data;

class AdminController extends Controller
{
    public function loginhandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if($fieldType == 'email'){
            $request->validate([
                'login_id'=>'required|email|exists:admins,email',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.email'=>'Invalid email address',
                'login_id.exists'=>'Email is not exists is system',
                'password.required'=>'Password is required'
            ]);
        }else{
            $request->validate([
                'login_id'=>'required|exists:admins,username',
                'password'=>'required|min:5|max:45',

            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.exists'=>'Username is not exists is system',
                'password.required'=>'Password is required'
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if (Auth::guard('admin')->attempt($creds)){
            return redirect()->route('admin.home');
        }else{
            session()->flash('fail','Incorrect credentials');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request){
        Auth::guard('admin')->logout();
        session()->flash('fail','You are logged out!');
        return redirect()->route('admin.login');
    }

    public function profileView(Request $request){
        $admin = null;
        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }

    public function importView(Request $request){
        $data = Data::all();
        $admin = null;
        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.import', ['data' => $data]);
    }

    public function viewAccounts(Request $request){
        $accounts = Admin::select('*', DB::raw('CONCAT(DATE_FORMAT(created_at, "%M %d, %Y %H:%i %p")) as date_created'))->get();
        $admin = null;
        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
        }
        $role = $admin->role === "admin" ? true : false;

        
        $data = [
            'pageTitle' => 'Account List',
            'accounts' => $accounts,
            'role' => $role,
            'actionMessage' => "hello",
            'color' => "success"
        ];

        return view('back.pages.user.accounts', $data);
    }

    
    public function storeAccount(Request $request){

        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if(!$data) {
            $actionMessage =  "Something went wrong with your data!";
            $color = "error";
            
            // Flashing the session data
            session()->flash('actionMessage', $actionMessage);
            session()->flash('color', $color);

            return redirect (route('admin.account-user'));
        }
        else {
            $checkExist = Admin::where('username', $request->username)->first();
            if($checkExist) {
                $actionMessage = "Account username already exist!";
                $color = "error";
            }
            else {
                $actionMessage = "Account Added Successfully!";
                $color = "success";
                $data['email'] = $request->username;
                Admin::create($data);   
            }
        }
    
        // Flashing the session data
        session()->flash('actionMessage', $actionMessage);
        session()->flash('color', $color);

        return redirect (route('admin.account-user'));
    }
    public function deleteAccount(Request $request){
        $delete = Admin::where('username', $request->username)->delete();
    
        if($delete) {
            $actionMessage = "Account Deleted Successfully!";
            $color = "success";
        }
        else {
            $actionMessage = "Error Deleting Account!";
            $color = "danger";
        }
    
        // Flashing the session data
        session()->flash('actionMessage', $actionMessage);
        session()->flash('color', $color);
    
        return redirect()->route('admin.account-user');
    }

    public function updateAccount(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required'
        ]);
        if($data) {
            $update = Admin::where('username', $request->username)->update([
                'name' => $request->name,
                'role' => $request->role
            ]);
            if($update) {
                $actionMessage = "Account Updated Successfully!";
                $color = "success";
            }
            else {
                $actionMessage = "Error Updating Account!";
                $color = "error";
            }
        }
        else {
            $actionMessage = "Error Updating Account!";
            $color = "danger";
        }
    
        // Flashing the session data
        session()->flash('actionMessage', $actionMessage);
        session()->flash('color', $color);
    
        return redirect()->route('admin.account-user');
    }
    
    public function homeView(Request $request)
    {
        $search = $request->get('search');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $query = Data::query();

        // Apply the search filter if present
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('latitude', 'like', '%' . $search . '%')
                    ->orWhere('longitude', 'like', '%' . $search . '%');
            });
        }
        // Apply the date range filter if present
        if ($start_date && $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->where('date', '>=', $start_date);
        } elseif ($end_date) {
            $query->where('date', '<=', $end_date);
        }

        $data = $query->select(
            'id', 
            'name', 
            'latitude', 
            'longitude', 
            'time', 
            'date',
            DB::raw("DATE_FORMAT(date, '%M %d, %Y') AS formatted_date"),
            DB::raw("DATE_FORMAT(time, '%h:%i %p') AS formatted_time")
        )
        ->orderBy('date', 'DESC')
        ->orderBy('time', 'DESC')
        ->paginate(10); // Adjust the number per page (10 here)

        return view('back.pages.admin.home', ['data' => $data]);
    }

}
