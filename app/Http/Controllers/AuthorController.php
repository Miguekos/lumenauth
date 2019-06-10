<?php

namespace App\Http\Controllers;

use App\Author;
use App\Autos;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function showAllAuthors()
    {

        // $asd = app('redis')->exists('autos');
        // $asd = app('redis')->set('$key', '$value');
        // $asd = app('redis')->get('$key');
        // $asd = app('redis')->expire('$key', '$value');
        // return $asd;
        $asd = app('redis')->exists('autos');
        if ($asd) {
            $autos = app('redis')->get('autos');
            return $autos;
        }else {
            $autosRedis = app('redis')->set('autos', Autos::all());
            $autos = app('redis')->get('autos');
            return $autos;
        }
        // return response()->json(Autos::all());
    }

    public function showOneAuthor($id)
    {
        return response()->json(Author::find($id));
    }

    public function create(Request $request)
    {
        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());
        return response()->json($author, 200);
    }

    public function delete($id)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
