<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Profile::orderBy('name', 'asc')->get();
        if($profile) {
            return response([
                'message' => 'success',
                'data' => $profile,
                'status' => 200
            ]);
        } else {
            return response([
                'message' => 'error',
                'data' => 'Not found',
                'status' => 400
            ]);
        }
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
        $request->validate([
            'data' => 'required'
        ]);
        $data_init = strtolower($request->data);
        $profile = false;
        $data = preg_replace('/\s?(tahun|thn|th)\s/', ' ', $data_init);
        preg_match('/([A-Za-z\s]+)\s(\d+)\s([A-Za-z\s]+)/', $data, $matches);
        if ($matches) {
            $name = trim($matches[1]);
            $age = $matches[2];
            $city = trim($matches[3]);
            $profile = Profile::create([
                'name' => strtoupper($name),
                'age' => strtoupper($age),
                'city' => strtoupper($city)
            ]);
            $profile = Profile::find($profile->id);
        }
        if($profile) {
            return response([
                'message' => 'success',
                'data' => $profile,
                'status' => 200
            ]);
        } else {
            return response([
                'message' => 'error',
                'data' => 'failed to insert',
                'status' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::find($id);
        if($profile) {
            return response([
                'message' => 'success',
                'data' => $profile,
                'status' => 200
            ]);
        } else {
            return response([
                'message' => 'error',
                'data' => 'Not found',
                'status' => 400
            ]);
        }
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
        $request->validate([
            'data' => 'required'
        ]);

        $data_init = strtolower($request->data);
        $profile = false;
        $data = preg_replace('/\s?(tahun|thn|th)\s/', ' ', $data_init);
        preg_match('/([A-Za-z\s]+)\s(\d+)\s([A-Za-z\s]+)/', $data, $matches);
        if ($matches) {
            $name = trim($matches[1]);
            $age = $matches[2];
            $city = trim($matches[3]);
            $profile = Profile::find($id);
            $profile->name = $name;
            $profile->age = $age;
            $profile->city = $city;
            $profile->save();
            
        }

        if($profile) {
            return response([
                'message' => 'success',
                'data' => $profile,
                'status' => 200
            ]);
        } else {
            return response([
                'message' => 'error',
                'data' => 'Not found',
                'status' => 400
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::find($id);
        if($profile) {
            $profile->delete();
            return response([
                'message' => 'success',
                'data' => "deleted",
                'status' => 200
            ]);
        } else {
            return response([
                'message' => 'error',
                'data' => 'Not found',
                'status' => 400
            ]);
        }
    }
}
