<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use App\Models\Data;

class DataController extends Controller
{
    /**
     * write code on method
     * 
     * @return response()
     */
    public function importData(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2024'
        ]);
        Excel::import(new DataImport, $request->file('file'));
        return back()->with('success', 'Data Imported Successfully!');
    }
    
}
