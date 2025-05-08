<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kalender;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kalender.index');
    }

    public function api()
    {
        $kalender = Kalender::all()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'start' => date('Y-m-d', strtotime($item->start)),
                'end' => date('Y-m-d', strtotime($item->end)),
                'className' => "info",
                'description' => $item->description,
                'url' => $item->url,
                'user_id' => $item->user_id,
            ];
        });
        return response()->json($kalender);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
