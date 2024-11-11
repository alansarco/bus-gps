<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Add;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ActiveController extends Controller
{
    public function ordersCustomer(Request $request){
        $data = [
            'pageTitle' => 'Customer list'
        ];
        return view('back.pages.admin.orders-Customer', $data);
    }

    public function addCustomer(Request $request){
        $data = [
            'pageTitle' => 'Add Customers'
        ];
        return view('back.pages.admin.add-Customer', $data);
    }

    // public function store-customer(Request $request){
    //     $request->validate([
    //         'client'=>'required|min:5|unique:client'
    //     ],[
    //         'client.required'=>':Attribute is required',
    //         'client.min'=>':Attribute must contains atlest 5 characters',
    //         'client.unique'=>'This : ttribute is already exists',
    //     ]);
    // }
}
