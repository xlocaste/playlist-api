<?php

namespace App\Http\Controllers\Api;

use App\Models\Lagu;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaguResource;
use App\Http\Requests\LaguRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaguController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $lagu = Lagu::latest()->paginate(5);

        //return collection of lagu as a resource
        return new LaguResource(true, 'List Data Lagu', $lagu);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(LaguRequest $request)
    {
        //upload mp3
        $mp3 = $request->file('mp3');
        $mp3->storeAs('public/lagu', $mp3->hashName());

        //create lagu
        $lagu = Lagu::create([
            'mp3'     => $mp3->hashName(),
            'title'     => $request->title,
        ]);

        //return response
        return new LaguResource(true, 'Data Lagu Berhasil Ditambahkan!', $lagu);
    }

    /**
     * show
     *
     * @param  mixed $lagu
     * @return void
     */
    public function show(Lagu $lagu)
    {
        //return single lagu as a resource
        return new LaguResource(true, 'Data Lagu Ditemukan!', $lagu);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $lagu
     * @return void
     */
    public function update(LaguRequest $request, Lagu $lagu)
    {
        //check if mp3 is not empty
        if ($request->hasFile('mp3')) {

            //upload mp3
            $mp3 = $request->file('mp3');
            $mp3->storeAs('public/lagu', $mp3->hashName());

            //delete old mp3
            Storage::delete('public/lagu/'.$lagu->mp3);

            //update lagu with new mp3
            $lagu->update([
                'mp3'     => $mp3->hashName(),
                'title'     => $request->title,
            ]);

        } else {

            //update lagu without mp3
            $lagu->update([
                'title'     => $request->title,
            ]);
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Lagu berhasil dirubah!',
        ]);
    }

    /**
     * destroy
     *
     * @param  mixed $lagu
     * @return void
     */
    public function destroy(lagu $lagu)
    {
        Storage::delete('public/lagu/' . $lagu->mp3);

        //delete lagu
        $lagu->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Lagu berhasil dihapus!',
        ]);
    }

    public function getAllSongs()
    {
        try {
            $lagu = Lagu::all();
            return response()->json($lagu);
        } catch (\Exception $e) {
            // Log error and return 500 response
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
