<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Division;
use Validator;
use Auth;
use DB;
use App\Helpers\Helper;

class DivisionController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$divisions = Division::orderBy("division_name", "ASC")->get();
        return view('divisions.index', ['divisions' => $divisions]);
    }

    public function add()
    {
        return view('divisions.add');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'division_name' => 'required|string|unique:divisions',
            'division_code' => 'required|string|unique:divisions'
        ]);
        $country_name = "";
        $state_name = "";

        $division = new Division;
        $division->division_code = $request->division_code;
        $division->division_name = $request->division_name;
        $division->location_code = 1;
        $division->is_active = 1;
        if($division->save())
        {
    		flash('Division has been added successfully.')->success();
    		return redirect('divisions'); 
        }
        else
        {
        	flash('Please fill the form correctly.')->error();
            return redirect()->back();
        }
    }
}
