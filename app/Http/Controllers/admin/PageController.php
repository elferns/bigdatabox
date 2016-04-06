<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;
use DB, Session, Crypt, Hash;

class PageController extends Controller
{

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @purpose To display page add form and page list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.page', ['moduleName' => 'pages']);
    }

    /**
     * @purpose To save and update page form
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
                                    'name' => 'required|unique:pages,name'.$rule_id,
                                    'title' => 'required|unique:pages,title'.$rule_id,
                                    'content' => 'required'
                                  ]
                        );

        if ($request->input('ref') != null) {
            $page = Page::find($id);
            $page->name = $request->input('name');
            $page->title = $request->input('title');
            $page->content = $request->input('content');
            $page->status = $request->input('status');
            $page->seo_keywords = $request->input('seo_keywords');
            $page->seo_description = $request->input('seo_description');
            $page->save();

            $msg_type = "Updated";
        } else {
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
            $msg_type = "Added";
        }
        return redirect('/admin/pages')->with('success_pages', $msg_type.' successfully');
    }

    /**
     * @purpose To send the list data
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_list()
    {
        //head
        $table_head = [ 'name' => [ 'label' => 'Name', 'sort' => true ],
                        'title' => [ 'label' => 'Title', 'sort' => true ],
                        'slug' => [ 'label' => 'Slug', 'sort' => true ],
                        'status' => [ 'label' => 'Status', 'sort' => true ],
                        'actions' => [ 'label' => 'Actions', 'sort' => false ] ];

        //get records
        $table_body = DB::table('pages')
                      ->select('id', 'name', 'title', 'slug',
                                DB::raw('if(status=1,"<i class=\"fa fa-check\"></i>" ,"<i class=\"fa fa-times\"></i>")
                                as status'))
                                ->get();
        //set default sort
        $table_sort = [ 'sortType' => 'name', 'sortReverse' => true ];
        //send the type if data that willbe displayed
        $table_datatype = [ 'name' => 'text', 'title' => 'text', 'slug' => 'text', 'status' => 'html'];
        return response()->json([ 'table_body' => $table_body, 'table_head' => $table_head,
            'table_sort' => $table_sort, 'table_datatype' => $table_datatype ]);
    }

    /**
     * @purpose To delete page
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_destroy($id)
    {
        $page = Page::find($id);
        Page::destroy($id);
        Session::flash('successMessage', $page->name.' deleted successfully');
        return response()->json(['message' => 'Deleted successfully', 'pageName' => $page->name]);
    }

    /**
     * @purpose To get data for a page
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function api_page($id)
    {
        $pageDetails = Page::find($id);
        $pageDetails->ref = Crypt::encrypt($pageDetails->id);
        return response()->json($pageDetails);
    }
}
