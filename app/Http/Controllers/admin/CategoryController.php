<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use DB, Session, Crypt, Hash;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.category', ['moduleName' => 'categories']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rule_id = "";
        if ($request->input('ref') != null) {
            $id = Crypt::decrypt($request->input('ref'));
            $rule_id = ",".$id;
        }

        $this->validate($request, [
                'name' => 'required|unique:pages,name'.$rule_id
            ]
        );


        if ($request->input('ref') != null) {
            $category = Category::find($id);
            $category->name = $request->input('name');
            $category->status = $request->input('status');
            $category->save();

            $msg_type = "Updated";
        } else {
            DB::table('categories')->insert(
                [
                    'name' => $request->input('name'),
                    'status' => ($request->has('status')) ? $request->input('status') : 0
                ]
            );
            $msg_type = "Added";
        }

        return redirect('/admin/categories')->with('success_categories', $msg_type.' successfully');
    }

    /**
     * @purpose To send the list data
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_list()
    {
        //head
        $table_head = [ 'name' => [ 'label' => 'Name', 'sort' => true ],
            'status' => [ 'label' => 'Status', 'sort' => true ],
            'actions' => [ 'label' => 'Actions', 'sort' => false ] ];

        //get records
        $table_body = DB::table('categories')
            ->select('id', 'name',
                DB::raw('if(status=1,"<i class=\"fa fa-check\"></i>" ,"<i class=\"fa fa-times\"></i>")
                                as status'))
            ->get();
        //set default sort
        $table_sort = [ 'sortType' => 'name', 'sortReverse' => false ];
        //send the type if data that willbe displayed
        $table_datatype = [ 'name' => 'text', 'status' => 'html'];
        return response()->json([ 'table_body' => $table_body, 'table_head' => $table_head,
            'table_sort' => $table_sort, 'table_datatype' => $table_datatype ]);
    }

    /**
     * @purpose To delete category
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_destroy($id)
    {
        $category = Category::find($id);
        Category::destroy($id);
        Session::flash('successMessage', $category->name.' deleted successfully');
        return response()->json(['message' => 'Deleted successfully', 'pageName' => $category->name]);
    }

    /**
     * @purpose To get data for a category
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_category($id)
    {
        $catDetails = Category::find($id);
        $catDetails->ref = Crypt::encrypt($catDetails->id);
        return response()->json($catDetails);
    }
}
