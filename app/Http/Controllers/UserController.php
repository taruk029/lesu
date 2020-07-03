<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Division;
use App\Designation;
use App\Monthly_contribution;
use App\Individual_year;
use App\Opening_balance;
use App\Year;
use App\Month;
use Validator;
use Auth;
use DB;
use App\Helpers\Helper;
use App\Rate_of_interest;

class UserController extends Controller
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
    public function index(Request $request)
    {
        $results =  DB::table('users')
        ->select("users.name as employee_name", 
            "users.id as user_id", 
            "divisions.division_code", 
            "divisions.division_name", 
            "designations.designation", 
            "users.account_type", 
            "users.account_no", 
            "users.phone", 
            "users.email", 
            "users.employee_type", 
            "users.phone")
        ->leftjoin("designations", "users.designation_id", "=", "designations.id")
        ->leftjoin("divisions", "users.division_id", "=", "divisions.id")
        ->where("users.role", 3);

        if(!empty($request->division))
        {
            $results->where('users.division_id', $request->division);
        }

        if(!empty($request->emp_type))
        {
            $results->where('users.employee_type', $request->emp_type);
        }

        $users = $results->get();
        $divisions = Division::orderBy("division_name", "ASC")->get();

        return view('users.index', ['users' => $users, 'divisions' => $divisions]);
    }


    public function add()
    {
    	$divisions = Division::orderBy('division_code', 'ASC')->get();
        $designation = Designation::get();

        return view('users.add', ['designation' => $designation, 'divisions' => $divisions]);
    }

    public function insert_employee(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'divisions' => 'required',
            'account_type' => 'required',
            'employee_type' => 'required',
            'designation' => 'required'
        ]);

        $pass = "12345678";
        if(!empty($request->password))
        {
            $pass = $request->password;
        }

        $user = new User;
        $user->name = $request->name;
        $user->account_type = $request->account_type;
        $user->employee_type = $request->employee_type;
        $user->account_no = $request->account_no;
        $user->division_id = $request->divisions;
        $user->designation_id = $request->designation;
        $user->phone = $request->phone;               
        $user->role = 3;
        $user->password = bcrypt($request->password);

        $image_url = "";
        $images_fileName = "";
        if($request->hasFile('images'))
        {
            $images = $request->file('images');
            $images_fileName = pathinfo($images->getClientOriginalName(), PATHINFO_FILENAME)."-".date('Ymdhis').'.'.$images->getClientOriginalExtension();
            $images->move(base_path().'/public/employee_picture/', $images_fileName);
            $image_url = url('/')."/public/employee_picture/".$images_fileName;
        }
        $user->profile_picture = $images_fileName;
        if($user->save())
        {

            flash('Employee has been added successfully.')->success();
            return redirect('employees');
        }
        else
        {
            flash('Please fill the form correctly.')->error();
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        if($id)
        {
            $user = User::select("users.name as employee_name", 
            "users.id as user_id", 
            "designations.designation", 
            "users.account_type", 
            "users.account_no", 
            "users.designation_id", 
            "users.division_id", 
            "users.phone", 
            "users.email", 
            "users.profile_picture", 
            "users.employee_type", 
            "users.phone")
            ->leftjoin("designations", "users.designation_id", "=", "designations.id")
            ->where("users.id", $id)
            ->first();

            $divisions = Division::orderBy('division_code', 'ASC')->get();
            $designation = Designation::get();

            return view('users.edit', ['user' => $user,'divisions' => $divisions,'designation' => $designation]);
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'divisions' => 'required',
            'account_type' => 'required',
            'designation' => 'required'
        ]);
        
        $user = User::find($request->user_id);
        $user->name = $request->name; 
        $user->account_type = $request->account_type;
        $user->employee_type = $request->employee_type;
        $user->account_no = $request->account_no;
        $user->division_id = $request->divisions;
        $user->designation_id = $request->designation;
        $user->email = $request->email;
        $user->phone = $request->phone;      
        $image_url = "";
        $images_fileName = "";
        if($request->hasFile('images'))
        {
            $user_old_profile = User::where('id', $request->user_id)->first();
            if($user_old_profile)
            {
                if(!empty($user_old_profile->profile_picture))
                {
                    $old_file = base_path().'/public/employee_picture/'.$user_old_profile->profile_picture;
                    if(file_exists($old_file))
                    {
                        unlink($old_file);
                    }
                }

                $images = $request->file('images');
                $images_fileName = pathinfo($images->getClientOriginalName(), PATHINFO_FILENAME)."-".date('Ymdhis').'.'.$images->getClientOriginalExtension();
                $images->move(base_path().'/public/employee_picture/', $images_fileName);
                $image_url = url('/')."/public/employee_picture/".$images_fileName;
            }
        }
        $user->profile_picture = $images_fileName;
        $user->updated_at = date("Y-m-d h:i:s");
        if($user->save())
        {            
            flash('Employee has been updated successfully.')->success();
            return redirect('employees'); 
        }
        else
        {
            flash('Please fill the form correctly.')->error();
            return redirect()->back();
        }
    }

    public function add_contribtuion(Request $request, $id)
    {
        if($id)
        {
            $year_data = array();
            $open_bal = "";
            $rate_oi = "";
            $user = User::select("users.name as employee_name", 
            "users.id as user_id", 
            "designations.designation", 
            "divisions.division_code", 
            "divisions.division_name", 
            "users.account_type", 
            "users.account_no", 
            "users.designation_id", 
            "users.division_id", 
            "users.phone", 
            "users.email", 
            "users.opening_balance", 
            "users.profile_picture", 
            "users.phone")
            ->leftjoin("designations", "users.designation_id", "=", "designations.id")
            ->leftjoin("divisions", "users.division_id", "=", "divisions.id")
            ->where("users.id", $id)
            ->first();

            $years = Year::get();

            if($request->year)
            {
                $check_data = Monthly_contribution::where("user_id",  $id)->where("year", $request->year)->get();

                if(!count($check_data))
                {
                    $month = Month::get();
                    foreach($month as $row)
                    {
                        $check_entry = Monthly_contribution::where("user_id",  $id)->where("year",$request->year)->where("month",$row->id)->first();
                        if(!$check_entry)
                        {
                            $new = new Monthly_contribution;
                            $new->user_id = $id;
                            $new->year = $request->year;
                            $new->month = $row->id;
                            $new->individual_year_id = \App\Helpers\Helper::get_individual_year($row->number, $request->year);
                            $new->division_id = $user->division_id;
                            $new->rate_of_interest = $request->interest;
                            $new->created_at = date("Y-m-d h:i:s");
                            $new->updated_at = date("Y-m-d h:i:s");
                            $new->save();
                        }
                    }
                }
                $open = Opening_balance::where("user_id", $id)->where("year_id", $request->year)->first();
                if($open)
                {
                    if($request->opening_balance)
                    {
                       $op = Opening_balance::find($open['id']);
                       $op->user_id =  $id;
                       $op->year_id= $request->year;
                       $op->balance= $request->opening_balance;
                       $op->save();
                        $open_bal = $request->opening_balance;
                    }
                    else
                    {
                        $open_bal = $open['balance'];
                    }
                }
                else
                {
                    if($request->opening_balance)
                    {
                       $op = new Opening_balance;
                       $op->user_id =  $id;
                       $op->year_id= $request->year;
                       $op->balance= $request->opening_balance;
                       $op->save();
                       $open_bal = $request->opening_balance;
                    }
                }
                $roi = Rate_of_interest::where("user_id", $id)->where("year_id", $request->year)->first();
                if($roi)
                {
                    if($request->interest)
                    {
                       $ro = Rate_of_interest::find($roi['id']);
                       $ro->user_id =  $id;
                       $ro->year_id= $request->year;
                       $ro->roi= $request->interest;
                       $ro->save();
                        $rate_oi = $request->interest;
                    }
                    else
                    {
                        $rate_oi = $roi['roi'];
                    }
                }
                else
                {
                    if($request->interest)
                    {
                       $ro = Rate_of_interest::find($roi['id']);
                       $ro = new Rate_of_interest;
                       $ro->user_id =  $id;
                       $ro->year_id= $request->year;
                       $ro->roi= $request->interest;
                       $ro->save();
                       $rate_oi = $request->interest;
                    }
                }
                $year_data = Monthly_contribution::select("monthly_contributions.id", "months.month", "months.number", "years.short", "monthly_contributions.contribution", "monthly_contributions.rate_of_interest", "monthly_contributions.withdrawl", "monthly_contributions.division_id", "monthly_contributions.arrear", "monthly_contributions.remark", "monthly_contributions.total", "individual_years.short as indi_year")
                ->leftjoin("years", "monthly_contributions.year", "=", "years.id")
                ->leftjoin("months", "monthly_contributions.month", "=", "months.id")
                ->leftjoin("individual_years", "monthly_contributions.individual_year_id", "=", "individual_years.id")
                ->where("monthly_contributions.year", $request->year)
                ->where("monthly_contributions.user_id",  $id)
                /*->orderBy("months.number", "ASC")*/
                ->get();  

                
            }
            $divisions = Division::orderBy('division_code', 'ASC')->get();
            return view('users.monthly_contributions', ['user' => $user,'years' => $years,'year_data' => $year_data,'divisions' => $divisions,'open_bal' => $open_bal,'rate_oi' => $rate_oi]);
        }
        else
       {
            flash('Something went wrong, please try again later.')->error();
            return redirect()->back();
       } 
    }

    public function save_contri_data(Request $request)
    {
        if(!empty($request->id) && !empty($request->type) && $request->value!="" )
        {   
            $datas = Monthly_contribution::find($request->id);
            if($request->type==1)
                $datas->contribution = $request->value;

            if($request->type==3)
                $datas->withdrawl = $request->value;

            if($request->type==4)
                $datas->division_id = $request->value;

            if($request->type==5)
                $datas->arrear = $request->value;

            if($request->type==6)
                $datas->remark = $request->value;

             $datas->total = $request->total_val;
            $datas->save();

            if($request->type==2)
            {
                $datas_m = Monthly_contribution::find($request->id);
                $month = $datas_m['month'];
                for($i=$month; $i<=12; $i++)
                {
                    DB::table('monthly_contributions')
                        ->where('user_id', $request->emp_id) 
                        ->where('year', $request->year) 
                        ->where('month', $i) 
                        ->limit(1)
                        ->update(array('rate_of_interest' => $request->value));
                }
            }
            echo 1;
        }
        else
            echo 0;
    }

    public function save_roi_data(Request $request)
    {
        if(!empty($request->emp_id) && !empty($request->year))
        {   
            $datas = Monthly_contribution::where("user_id", $request->emp_id)->where("year", $request->year)->get();
            foreach ($datas as $key => $value) {
                $save_datas = Monthly_contribution::find($value->id);
                $save_datas->rate_of_interest = $request->value;
                $save_datas->save();
            }
            echo 1;
        }
        else
            echo 0;
    }

    public function check_account_no(Request $request)
    {
        if(!empty($request->account_no) && !empty($request->account_type))
        {   
            $datas = User::where("account_type", $request->account_type)->where("account_no", $request->account_no)->first();
            if($datas)
                echo 1;
            else
                echo 2;
        }
        else
            echo 0;
    }

    public function get_opening_bal(Request $request)
    {
        if(!empty($request->emp_id) && !empty($request->year))
        {   
            $open = "";
            $rate = "";
            $res = array();
            $datas = Opening_balance::where("user_id", $request->emp_id)->where("year_id", $request->year)->first();
            if($datas)
            {
                $rate_data = Rate_of_interest::where("user_id", $request->emp_id)->where("year_id", $request->year)->first();
                {
                    $res = array("open"=>$datas['balance'], "roi"=>$rate_data['roi']);
                }
            }
            echo json_encode($res);
        }
        else
            echo "false";
    }

    public function indi_report(Request $request)
    {
        $open = "";
        $year_data = array();
        $user = array();
        if(!empty($request->account_type) && !empty($request->acc_num) && !empty($request->year))
        {               
            $id = \App\Helpers\Helper::get_id_from_account($request->account_type, $request->acc_num);
            if($id)
            {
                $year_data = Monthly_contribution::select("monthly_contributions.id", "months.month", "months.number", "years.short", "monthly_contributions.contribution", "monthly_contributions.rate_of_interest", "monthly_contributions.withdrawl", "monthly_contributions.division_id", "monthly_contributions.arrear", "monthly_contributions.remark", "monthly_contributions.total", "individual_years.short as indi_year")
                ->leftjoin("years", "monthly_contributions.year", "=", "years.id")
                ->leftjoin("months", "monthly_contributions.month", "=", "months.id")
                ->leftjoin("individual_years", "monthly_contributions.individual_year_id", "=", "individual_years.id")
                ->where("monthly_contributions.year", $request->year)
                ->where("monthly_contributions.user_id",  $id)
                /*->orderBy("months.number", "ASC")*/
                ->get(); 

                $open = Opening_balance::select('balance')->where("user_id", $id)->where("year_id", $request->year)->first();

                $user = User::select("users.name as employee_name", 
                "users.id as user_id", 
                "designations.designation", 
                "divisions.division_code", 
                "divisions.division_name", 
                "users.account_type", 
                "users.account_no", 
                "users.designation_id", 
                "users.division_id", 
                "users.phone", 
                "users.email", 
                "users.opening_balance", 
                "users.profile_picture", 
                "users.phone")
                ->leftjoin("designations", "users.designation_id", "=", "designations.id")
                ->leftjoin("divisions", "users.division_id", "=", "divisions.id")
                ->where("users.id", $id)
                ->first();
            }
        }
        $years = Year::get();
        return view('users.indi_report', ['years' => $years, 'year_data' => $year_data, 'open' => $open, 'user' => $user]);
    }


    public function print_indi_view($user_id, $year)
    {

        $year_data = Monthly_contribution::select("monthly_contributions.id", "months.month", "months.number", "years.short", "monthly_contributions.contribution", "monthly_contributions.rate_of_interest", "monthly_contributions.withdrawl", "monthly_contributions.division_id", "monthly_contributions.arrear", "monthly_contributions.remark", "monthly_contributions.total", "individual_years.short as indi_year")
                ->leftjoin("years", "monthly_contributions.year", "=", "years.id")
                ->leftjoin("months", "monthly_contributions.month", "=", "months.id")
                ->leftjoin("individual_years", "monthly_contributions.individual_year_id", "=", "individual_years.id")
                ->where("monthly_contributions.year", $year)
                ->where("monthly_contributions.user_id",  $user_id)
                ->get();

        $user = User::select("users.name as employee_name", 
                "users.id as user_id", 
                "designations.designation", 
                "divisions.division_code", 
                "divisions.division_name", 
                "users.account_type", 
                "users.account_no", 
                "users.designation_id", 
                "users.division_id", 
                "users.phone", 
                "users.email", 
                "users.opening_balance", 
                "users.profile_picture", 
                "users.phone")
                ->leftjoin("designations", "users.designation_id", "=", "designations.id")
                ->leftjoin("divisions", "users.division_id", "=", "divisions.id")
                ->where("users.id", $user_id)
                ->first();

        $open = Opening_balance::select('balance')->where("user_id", $user_id)->where("year_id", $year)->first();
        $years = Year::find($year);
        return view('users.print_indi_report', ['years' => $years, 'year_data' => $year_data, 'open' => $open, 'user' => $user]);
    } 

    public function proof_sheet(Request $request)
    {
        $year_data = array();
        $selected_division = array();
        $user = array();
        $selected_year = array();
        if(!empty($request->year) && !empty($request->division))
        {
            $year_data = DB::select("SELECT 
                        `users`.`id` as user_id,
                        `users`.`name`,
                        `designations`.`designation`,
                        `users`.`account_no`,
                        MAX(IF(`month` = 1, `contribution`, NULL)) AS april_contri,
                        MAX(IF(`month` = 1, `rate_of_interest`, NULL)) AS april_roi,
                        MAX(IF(`month` = 1, `withdrawl`, NULL)) AS april_withd,
                        MAX(IF(`month` = 1, `individual_year_id`, NULL)) AS april_year,
                        MAX(IF(`month` = 1, `arrear`, NULL)) AS april_arrear,

                        MAX(IF(`month` = 2, `contribution`, NULL)) AS may_contri,
                        MAX(IF(`month` = 2, `rate_of_interest`, NULL)) AS may_roi,
                        MAX(IF(`month` = 2, `withdrawl`, NULL)) AS may_withd,
                        MAX(IF(`month` = 2, `arrear`, NULL)) AS may_arrear,
                        MAX(IF(`month` = 2, `individual_year_id`, NULL)) AS may_year,

                        MAX(IF(`month` = 3, `contribution`, NULL)) AS june_contri,
                        MAX(IF(`month` = 3, `rate_of_interest`, NULL)) AS june_roi,
                        MAX(IF(`month` = 3, `withdrawl`, NULL)) AS june_withd,
                        MAX(IF(`month` = 3, `arrear`, NULL)) AS june_arrear,
                        MAX(IF(`month` = 3, `individual_year_id`, NULL)) AS june_year,

                        MAX(IF(`month` = 4, `contribution`, NULL)) AS july_contri,
                        MAX(IF(`month` = 4, `rate_of_interest`, NULL)) AS july_roi,
                        MAX(IF(`month` = 4, `withdrawl`, NULL)) AS july_withd,
                        MAX(IF(`month` = 4, `individual_year_id`, NULL)) AS july_year,
                        MAX(IF(`month` = 4, `arrear`, NULL)) AS july_arrear,

                        MAX(IF(`month` = 5, `contribution`, NULL)) AS aug_contri,
                        MAX(IF(`month` = 5, `rate_of_interest`, NULL)) AS aug_roi,
                        MAX(IF(`month` = 5, `withdrawl`, NULL)) AS aug_withd,
                        MAX(IF(`month` = 5, `individual_year_id`, NULL)) AS aug_year,
                        MAX(IF(`month` = 5, `arrear`, NULL)) AS aug_arrear,

                        MAX(IF(`month` = 6, `contribution`, NULL)) AS sep_contri,
                        MAX(IF(`month` = 6, `rate_of_interest`, NULL)) AS sep_roi,
                        MAX(IF(`month` = 6, `withdrawl`, NULL)) AS sep_withd,
                        MAX(IF(`month` = 6, `individual_year_id`, NULL)) AS sep_year,
                        MAX(IF(`month` = 6, `arrear`, NULL)) AS sep_arrear,

                        MAX(IF(`month` = 7, `contribution`, NULL)) AS oct_contri,
                        MAX(IF(`month` = 7, `rate_of_interest`, NULL)) AS oct_roi,
                        MAX(IF(`month` = 7, `withdrawl`, NULL)) AS oct_withd,
                        MAX(IF(`month` = 7, `individual_year_id`, NULL)) AS oct_year,
                        MAX(IF(`month` = 7, `arrear`, NULL)) AS oct_arrear,

                        MAX(IF(`month` = 8, `contribution`, NULL)) AS nov_contri,
                        MAX(IF(`month` = 8, `rate_of_interest`, NULL)) AS nov_roi,
                        MAX(IF(`month` = 8, `withdrawl`, NULL)) AS nov_withd,
                        MAX(IF(`month` = 8, `individual_year_id`, NULL)) AS nov_year,
                        MAX(IF(`month` = 8, `arrear`, NULL)) AS nov_arrear,

                        MAX(IF(`month` = 9, `contribution`, NULL)) AS dec_contri,
                        MAX(IF(`month` = 9, `rate_of_interest`, NULL)) AS dec_roi,
                        MAX(IF(`month` = 9, `withdrawl`, NULL)) AS dec_withd,
                        MAX(IF(`month` = 9, `individual_year_id`, NULL)) AS dec_year,
                        MAX(IF(`month` = 9, `arrear`, NULL)) AS dec_arrear,

                        MAX(IF(`month` = 10, `contribution`, NULL)) AS jan_contri,
                        MAX(IF(`month` = 10, `rate_of_interest`, NULL)) AS jan_roi,
                        MAX(IF(`month` = 10, `withdrawl`, NULL)) AS jan_withd,
                        MAX(IF(`month` = 10, `individual_year_id`, NULL)) AS jan_year,
                        MAX(IF(`month` = 10, `arrear`, NULL)) AS jan_arrear,

                        MAX(IF(`month` = 11, `contribution`, NULL)) AS feb_contri,
                        MAX(IF(`month` = 11, `rate_of_interest`, NULL)) AS feb_roi,
                        MAX(IF(`month` = 11, `withdrawl`, NULL)) AS feb_withd,
                        MAX(IF(`month` = 11, `individual_year_id`, NULL)) AS feb_year,
                        MAX(IF(`month` = 11, `arrear`, NULL)) AS feb_arrear,

                        MAX(IF(`month` = 12, `contribution`, NULL)) AS march_contri,
                        MAX(IF(`month` = 12, `rate_of_interest`, NULL)) AS march_roi,
                        MAX(IF(`month` = 12, `withdrawl`, NULL)) AS march_withd,
                        MAX(IF(`month` = 12, `individual_year_id`, NULL)) AS march_year,
                        MAX(IF(`month` = 12, `arrear`, NULL)) AS march_arrear
                        FROM `monthly_contributions`
                        LEFT JOIN `users` ON `users`.`id` = `monthly_contributions`.`user_id`
                        LEFT JOIN `designations` ON `designations`.`id` = `users`.`designation_id`
                        WHERE `users`.`division_id` = ".$request->division." AND `monthly_contributions`.`year`= ".$request->year." GROUP BY `monthly_contributions`.`user_id`;"
                );
            $selected_year = Year::find($request->year);
            $selected_division = Division::select('division_name')->where("id", $request->division)->first();
        }
        $years = Year::get();
        $month = Month::get();
        $divisions = Division::orderBy("division_name", "ASC")->get();
        return view('users.proof_sheet', ['years' => $years, 'year_data' => $year_data, 'divisions' => $divisions, 'month' => $month, 'selected_year' => $selected_year, 'selected_division' => $selected_division]);
    }
   

    public function print_proof_sheet($division_id, $year)
    {
        $year_data = array();
        $selected_division = array();
        $user = array();
        $selected_year = array();
        if(!empty($year) && !empty($division_id))
        {
            $year_data = DB::select("SELECT 
                        `users`.`id` as user_id,
                        `users`.`name`,
                        `designations`.`designation`,
                        `users`.`account_no`,
                        MAX(IF(`month` = 1, `contribution`, NULL)) AS april_contri,
                        MAX(IF(`month` = 1, `rate_of_interest`, NULL)) AS april_roi,
                        MAX(IF(`month` = 1, `withdrawl`, NULL)) AS april_withd,
                        MAX(IF(`month` = 1, `individual_year_id`, NULL)) AS april_year,
                        MAX(IF(`month` = 1, `arrear`, NULL)) AS april_arrear,

                        MAX(IF(`month` = 2, `contribution`, NULL)) AS may_contri,
                        MAX(IF(`month` = 2, `rate_of_interest`, NULL)) AS may_roi,
                        MAX(IF(`month` = 2, `withdrawl`, NULL)) AS may_withd,
                        MAX(IF(`month` = 2, `arrear`, NULL)) AS may_arrear,
                        MAX(IF(`month` = 2, `individual_year_id`, NULL)) AS may_year,

                        MAX(IF(`month` = 3, `contribution`, NULL)) AS june_contri,
                        MAX(IF(`month` = 3, `rate_of_interest`, NULL)) AS june_roi,
                        MAX(IF(`month` = 3, `withdrawl`, NULL)) AS june_withd,
                        MAX(IF(`month` = 3, `arrear`, NULL)) AS june_arrear,
                        MAX(IF(`month` = 3, `individual_year_id`, NULL)) AS june_year,

                        MAX(IF(`month` = 4, `contribution`, NULL)) AS july_contri,
                        MAX(IF(`month` = 4, `rate_of_interest`, NULL)) AS july_roi,
                        MAX(IF(`month` = 4, `withdrawl`, NULL)) AS july_withd,
                        MAX(IF(`month` = 4, `individual_year_id`, NULL)) AS july_year,
                        MAX(IF(`month` = 4, `arrear`, NULL)) AS july_arrear,

                        MAX(IF(`month` = 5, `contribution`, NULL)) AS aug_contri,
                        MAX(IF(`month` = 5, `rate_of_interest`, NULL)) AS aug_roi,
                        MAX(IF(`month` = 5, `withdrawl`, NULL)) AS aug_withd,
                        MAX(IF(`month` = 5, `individual_year_id`, NULL)) AS aug_year,
                        MAX(IF(`month` = 5, `arrear`, NULL)) AS aug_arrear,

                        MAX(IF(`month` = 6, `contribution`, NULL)) AS sep_contri,
                        MAX(IF(`month` = 6, `rate_of_interest`, NULL)) AS sep_roi,
                        MAX(IF(`month` = 6, `withdrawl`, NULL)) AS sep_withd,
                        MAX(IF(`month` = 6, `individual_year_id`, NULL)) AS sep_year,
                        MAX(IF(`month` = 6, `arrear`, NULL)) AS sep_arrear,

                        MAX(IF(`month` = 7, `contribution`, NULL)) AS oct_contri,
                        MAX(IF(`month` = 7, `rate_of_interest`, NULL)) AS oct_roi,
                        MAX(IF(`month` = 7, `withdrawl`, NULL)) AS oct_withd,
                        MAX(IF(`month` = 7, `individual_year_id`, NULL)) AS oct_year,
                        MAX(IF(`month` = 7, `arrear`, NULL)) AS oct_arrear,

                        MAX(IF(`month` = 8, `contribution`, NULL)) AS nov_contri,
                        MAX(IF(`month` = 8, `rate_of_interest`, NULL)) AS nov_roi,
                        MAX(IF(`month` = 8, `withdrawl`, NULL)) AS nov_withd,
                        MAX(IF(`month` = 8, `individual_year_id`, NULL)) AS nov_year,
                        MAX(IF(`month` = 8, `arrear`, NULL)) AS nov_arrear,

                        MAX(IF(`month` = 9, `contribution`, NULL)) AS dec_contri,
                        MAX(IF(`month` = 9, `rate_of_interest`, NULL)) AS dec_roi,
                        MAX(IF(`month` = 9, `withdrawl`, NULL)) AS dec_withd,
                        MAX(IF(`month` = 9, `individual_year_id`, NULL)) AS dec_year,
                        MAX(IF(`month` = 9, `arrear`, NULL)) AS dec_arrear,

                        MAX(IF(`month` = 10, `contribution`, NULL)) AS jan_contri,
                        MAX(IF(`month` = 10, `rate_of_interest`, NULL)) AS jan_roi,
                        MAX(IF(`month` = 10, `withdrawl`, NULL)) AS jan_withd,
                        MAX(IF(`month` = 10, `individual_year_id`, NULL)) AS jan_year,
                        MAX(IF(`month` = 10, `arrear`, NULL)) AS jan_arrear,

                        MAX(IF(`month` = 11, `contribution`, NULL)) AS feb_contri,
                        MAX(IF(`month` = 11, `rate_of_interest`, NULL)) AS feb_roi,
                        MAX(IF(`month` = 11, `withdrawl`, NULL)) AS feb_withd,
                        MAX(IF(`month` = 11, `individual_year_id`, NULL)) AS feb_year,
                        MAX(IF(`month` = 11, `arrear`, NULL)) AS feb_arrear,

                        MAX(IF(`month` = 12, `contribution`, NULL)) AS march_contri,
                        MAX(IF(`month` = 12, `rate_of_interest`, NULL)) AS march_roi,
                        MAX(IF(`month` = 12, `withdrawl`, NULL)) AS march_withd,
                        MAX(IF(`month` = 12, `individual_year_id`, NULL)) AS march_year,
                        MAX(IF(`month` = 12, `arrear`, NULL)) AS march_arrear
                        FROM `monthly_contributions`
                        LEFT JOIN `users` ON `users`.`id` = `monthly_contributions`.`user_id`
                        LEFT JOIN `designations` ON `designations`.`id` = `users`.`designation_id`
                        WHERE `users`.`division_id` = ".$division_id." AND `monthly_contributions`.`year`= ".$year." GROUP BY `monthly_contributions`.`user_id`;"
                );
            $selected_year = Year::find($year);
            $selected_division = Division::select('division_name')->where("id", $division_id)->first();
        }
        $years = Year::get();
        $month = Month::get();
        $divisions = Division::orderBy("division_name", "ASC")->get();
        return view('users.print_proof_sheet', ['years' => $years, 'year_data' => $year_data, 'divisions' => $divisions, 'month' => $month, 'selected_year' => $selected_year, 'selected_division' => $selected_division]);
    }
   

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function exportFile($type, $user_id, $year){

        $data = $year_data = Monthly_contribution::select("monthly_contributions.id", "months.month", "months.number", "years.short", "monthly_contributions.contribution", "monthly_contributions.rate_of_interest", "monthly_contributions.withdrawl", "monthly_contributions.division_id", "monthly_contributions.arrear", "monthly_contributions.remark", "monthly_contributions.total", "individual_years.short as indi_year")
                ->leftjoin("years", "monthly_contributions.year", "=", "years.id")
                ->leftjoin("months", "monthly_contributions.month", "=", "months.id")
                ->leftjoin("individual_years", "monthly_contributions.individual_year_id", "=", "individual_years.id")
                ->where("monthly_contributions.year", $year)
                ->where("monthly_contributions.user_id",  $user_id)
                ->get()
                /*->orderBy("months.number", "ASC")*/
                ->toArray();

        $user = User::select("users.name as employee_name", 
                "users.id as user_id", 
                "designations.designation", 
                "divisions.division_code", 
                "divisions.division_name", 
                "users.account_type", 
                "users.account_no", 
                "users.designation_id", 
                "users.division_id", 
                "users.phone", 
                "users.email", 
                "users.opening_balance", 
                "users.profile_picture", 
                "users.phone")
                ->leftjoin("designations", "users.designation_id", "=", "designations.id")
                ->leftjoin("divisions", "users.division_id", "=", "divisions.id")
                ->where("users.id", $user_id)
                ->first();

            $data['title'] = $user['division_name'];
            echo "<pre>";
            print_r($data);die;

        return \Excel::create('hdtuto_demo', function($excel) use ($data) {

            $excel->sheet('sheet name', function($sheet) use ($data)

            {
                $sheet->setHeight(array(
                    1     =>  50,
                    8    =>  25,
                ));

                $sheet->setWidth(array(
                    'A'     =>  25,
                    'B'     =>  15,
                    'C'     =>  15,
                    'D'     =>  20,
                    'E'     =>  22,
                    'F'     =>  10,
                    'G'     =>  22,
                    'I'     =>  25,
                    'J'     =>  18,
                    'K'     =>  18,
                ));

                $sheet->mergeCells('A1:K1');
                $sheet->cells('A1:K1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBackground('#bdd7ee');
                    $cells->setFontFamily('Calibri');
                    $cells->setFontColor('#000000');
                    $cells->setFontSize(18);
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });
                $sheet->row(1, array($data['title']));
                $sheet->fromArray($data);

            });

        })->download($type);

    }    
}
