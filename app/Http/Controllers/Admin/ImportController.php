<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function importRaport(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Handle the file import logic here
        // For example, you can use a package like Maatwebsite Excel to import the file

        return response()->json(['message' => 'File imported successfully']);
    }

    
}
