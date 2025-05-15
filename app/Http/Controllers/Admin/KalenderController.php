<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateKalenderRequest;
use App\Http\Requests\UpdateKalenderRequest;
use App\Models\Kalender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'user_id' => $item->user_id,
                'type' => $item->type,
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
    public function store(CreateKalenderRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['className'] = $validated['type'] == 'ujian' ? 'danger' : 'info';
            $kalender = Kalender::create($validated);
            return response()->json($kalender);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
    public function update(UpdateKalenderRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $kalender = Kalender::find($id);
            if ($kalender->user_id != $validated['user_id']) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $validated['className'] = $validated['type'] == 'ujian' ? 'danger' : 'info';
            $kalender->update($validated);
            return response()->json($kalender);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
