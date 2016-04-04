<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class BannerController extends Controller
{
    /**
     * BannerController constructor.
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
        return view('admin.banner', [ 'moduleName' => 'banners' ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image_name' => 'required|mimes:jpeg,png,jpg,JPG|max:1000'
        ]);

        $destination_path = "uploads/banners";
        $file_ext = $request->file('image_name')->getClientOriginalExtension();
        $file_name = Carbon::now()->getTimestamp().".".$file_ext;
        $request->file('image_name')->move($destination_path, $file_name);

        DB::table('banners')->insert([
            'name' => $request->input('name'),
            'caption' => $request->input('caption'),
            'image_name' => $file_name
        ]);
        $msg_type = "Added";

        return redirect('/admin/banners')->with('success_banners', $msg_type.' successfully');
    }

    public function api_list()
    {
        $tab_links = DB::table('pages')->paginate(2);
        dd($tab_links->links());
        //head
        $table_head = [ 'name' => [ 'label' => 'Name', 'sort' => true, 'name' => 'name' ],
                        'caption' => [ 'label' => 'Caption', 'sort' => true, 'name' => 'caption' ],
                        'image' => [ 'label' => 'Image', 'sort' => false, 'name' => 'image' ],
                        'actions' => [ 'label' => 'Actions', 'sort' => false, 'name' => 'actions' ] ];

        //get records
        $table_body = DB::table('banners')->get();
        //set default sort
        $table_sort = [ 'sortType' => 'name', 'sortReverse' => true ];
        return response()->json([ 'table_body' => $table_body, 'table_head' => $table_head,
                                  'table_sort' => $table_sort, 'links' => $tab_links ]);
    }
}
