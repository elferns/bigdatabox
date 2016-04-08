<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Navigation;
use App\Page;
use DB, Session, Crypt, Hash;

class NavigationController extends Controller
{
    /**
     * NavigationController constructor.
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
        $pages = Page::where('status', 1)->lists('name', 'id');
        $order = array_combine(range(1,10),range(1,10));
        return view('admin.navigation', ['moduleName' => 'navigation', 'pages' => $pages, 'order' => $order]);
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
                'name' => 'required|unique:navigations,name'.$rule_id
            ]
        );


        if ($request->input('ref') != null) {
            $navigation = Navigation::find($id);
            $navigation->name = $request->input('name');
            $navigation->page_id = $request->input('page_id');
            $navigation->order_no = $request->input('order_no');
            $navigation->status = $request->input('status');
            $navigation->save();

            $msg_type = "Updated";
        } else {
            DB::table('navigations')->insert(
                [
                    'name' => $request->input('name'),
                    'page_id' => $request->input('page_id'),
                    'order_no' => $request->input('order_no'),
                    'status' => ($request->has('status')) ? $request->input('status') : 0
                ]
            );
            $msg_type = "Added";
        }

        return redirect('/admin/navigation')->with('success_navigation', $msg_type.' successfully');
    }

    /**
     * @purpose To send the list data
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_list()
    {
        //head
        $table_head = [ 'name' => [ 'label' => 'Name', 'sort' => true ],
                        'page' => [ 'label' => 'Page', 'sort' => true ],
                        'order_no' => [ 'label' => 'Order no', 'sort' => true ],
                        'status' => [ 'label' => 'Status', 'sort' => true ],
                        'actions' => [ 'label' => 'Actions', 'sort' => false ] ];

        //get records
        $table_body = DB::table('navigations as n')
                                 ->select('n.id', 'n.name', 'p.name as page', 'n.order_no',
                                DB::raw('if(n.status=1,"<i class=\"fa fa-check\"></i>" ,"<i class=\"fa fa-times\"></i>")
                                as status'))
                                ->leftJoin('pages as p', 'n.page_id', '=', 'p.id')
                                ->get();
        //set default sort
        $table_sort = [ 'sortType' => 'name', 'sortReverse' => false ];
        //send the type if data that will be displayed
        $table_datatype = [ 'name' => 'text', 'page' => 'text', 'order_no' => 'text', 'status' => 'html'];
        return response()->json([ 'table_body' => $table_body, 'table_head' => $table_head,
            'table_sort' => $table_sort, 'table_datatype' => $table_datatype ]);
    }

    /**
     * @purpose To delete navigation
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_destroy($id)
    {
        $navigation = Navigation::find($id);
        Navigation::destroy($id);
        Session::flash('successMessage', $navigation->name.' deleted successfully');
        return response()->json(['message' => 'Deleted successfully', 'pageName' => $navigation->name]);
    }

    /**
     * @purpose To get data for a navigation
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_navigation($id)
    {
        $navDetails = Navigation::find($id);
        $navDetails->ref = Crypt::encrypt($navDetails->id);
        return response()->json($navDetails);
    }
}
