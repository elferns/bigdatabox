<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Banner;
use DB, Session, Crypt, Hash, File;

class BannerController extends Controller
{

    protected $image_path = "uploads/banners/";

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
        if ($request->input('ref') != null) {
            $id = Crypt::decrypt($request->input('ref'));
        }

        if($request->file('image_name') != null) {
            $this->validate($request, [
                'name' => 'required',
                'image_name' => 'required|mimes:jpeg,png,jpg,JPG|max:1000'
            ]);

            $file_ext = $request->file('image_name')->getClientOriginalExtension();
            $file_name = Carbon::now()->getTimestamp().".".$file_ext;
            $request->file('image_name')->move($this->image_path, $file_name);

        } else {
            $this->validate($request, [
                'name' => 'required'
            ]);
        }

        if ($request->input('ref') != null) {
            $banner = Banner::find($id);
            $banner->name = $request->input('name');
            $banner->caption = $request->input('caption');
            if($request->file('image_name') != null) {
                File::delete($this->image_path.$banner->image_name);
                $banner->image_name = $file_name;
            }
            $banner->save();
            $msg_type = "Updated";
        } else {
            DB::table('banners')->insert([
                'name' => $request->input('name'),
                'caption' => $request->input('caption'),
                'image_name' => $file_name
            ]);
            $msg_type = "Added";
        }

        return redirect('/admin/banners')->with('success_banners', $msg_type.' successfully');
    }

    /**
     * @purpose To send the list data
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_list()
    {
        //head
        $table_head = [ 'name' => [ 'label' => 'Name', 'sort' => true ],
                        'caption' => [ 'label' => 'Caption', 'sort' => true ],
                        'image' => [ 'label' => 'Image', 'sort' => false ],
                        'actions' => [ 'label' => 'Actions', 'sort' => false ] ];

        //get records
        $table_body = DB::table('banners')->select('id', 'name', 'caption', 'image_name')
                                          ->get();
        //set default sort
        $table_sort = [ 'sortType' => 'name', 'sortReverse' => true ];
        //send the type if data that willbe displayed
        $table_datatype = [ 'name' => 'text', 'caption' => 'text', 'image_name' => 'image'];
        return response()->json([ 'table_body' => $table_body, 'table_head' => $table_head,
                                  'table_sort' => $table_sort, 'table_datatype' => $table_datatype,
                                  'image_path' => $this->image_path ]);
    }

    /**
     * @purpose To delete banner
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_destroy($id)
    {
        $banner = Banner::find($id);
        File::delete($this->image_path.$banner->image_name);
        Banner::destroy($id);
        Session::flash('successMessage', $banner->name.' deleted successfully');
        return response()->json(['message' => 'Deleted successfully', 'name' => $banner->name]);
    }

    public function api_banner($id)
    {
        $bannerDetails = Banner::find($id);
        $bannerDetails->image = '/'.$this->image_path.'/'.$bannerDetails->image_name;
        $bannerDetails->ref = Crypt::encrypt($bannerDetails->id);
        return response()->json($bannerDetails);
    }
}
