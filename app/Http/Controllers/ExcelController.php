<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StoreImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    

    public function upload(Request $request)
    {

        try {
           

            Excel::import(new StoreImport, $request->file('file'));

  
            return back()->with('success', 'Import successfully');
        } catch (\Exception $e) {
            
            return back()->withErrors(['error' => $e->getMessage()]);
           
        }
      
    }
}
