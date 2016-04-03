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
        return view('admin.banner');
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
}
