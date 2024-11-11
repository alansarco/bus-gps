<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\YourModel; // Replace with your actual model
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MapController extends Controller
{
    public function showLocation($encryptedId)
    {
        try {
            // Decrypt the ID
            $id = Crypt::decrypt($encryptedId);
    
            // Fetch the data using the decrypted ID

            $data = Data::selectRaw('*, 
                DATE_FORMAT(date, "%M %d, %Y") as formatted_date, 
                DATE_FORMAT(time, "%l:%i %p") as formatted_time')
            ->findOrFail($id);
    
            return view('back.pages.admin.show', compact('data'));
        } catch (DecryptException $e) {
            // Handle the case where decryption fails (invalid ID)
            return redirect()->route('admin.home')->with('error', 'Invalid ID');
        }
    }
}