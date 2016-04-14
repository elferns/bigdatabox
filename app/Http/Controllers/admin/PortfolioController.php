<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Portfolio;
use DB, Session, Crypt, Hash, File;

class PortfolioController extends Controller
{

	protected $image_path = "uploads/websites/";
    
    /**
     * PortfolioController constructor.
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
    	return view('admin.portfolio', [ 'moduleName' => 'portfolio', 'launchDate' =>  Carbon::now() ]);
    }

    public function store(Request $request)
    {

    }
}
