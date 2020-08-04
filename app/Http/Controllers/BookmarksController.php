<?php

namespace App\Http\Controllers;

use App\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
// use Symfony\Component\HttpFoundation\Session\Session;

class BookmarksController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'urldata' => 'required'
        ]);

        if($validator->fails())
        {
            return response([
                'errors' => [
                    $validator->messages()
                ]
            ]);
        }

        $bookmark = new Bookmark;
        $bookmark->name = $request->name;
        $bookmark->url = $request->urldata;
        $bookmark->description = $request->description;
        // $bookmark->user_id = Auth::id();
        // $bookmark->save();
        Auth::user()->bookmarks()->save($bookmark);

        // Session::flash('message', 'This is a message!'); 

        Session::flash('success', 'Bookmark was added successfully!');

        return response([
            'success' => [
                'Bookmark was added successfully!'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookmark = Bookmark::find($id);
        $bookmark->delete();
        Session::flash('success', 'Bookmark was deleted successfully!');
    }
}
