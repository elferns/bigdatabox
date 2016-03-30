<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PageController extends Controller
{
    /**
     * PageController constructor.
     */
    public function __construct()
    {
        //TODO
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = DB::table('pages')->paginate(2);
        return view('admin.page', ['pages' => $pages]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:pages,name|max:100',
            'title' => 'required|unique:pages,title',
            'content' => 'required'
        ]);

        DB::table('pages')->insert(
            [
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'slug' => str_slug($request->input('title'), '-'),
                'content' => $request->input('content'),
                'status' => ($request->has('status')) ? $request->input('status') : 0,
                'seo_keywords' => $request->input('seo_keywords'),
                'seo_description' => $request->input('seo_description'),
            ]
        );

        return redirect('/admin/pages')->with('success_pages', 'added successfully');
    }
}
