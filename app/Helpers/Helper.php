<?php

namespace App\Helpers;


use App\Location;
use App\User;
use App\Quarters;
use App\Employee_skill_rating;
use App\Year;
use App\Individual_year;
use App\Opening_balance;

class Helper {

    public static function get_id_from_account($account_type, $account) 
    {
      $data_id = User::select('id')
      ->where('account_type', $account_type)
      ->where('account_no', $account)
      ->first();
      return $data_id['id'];
    }

    public static function get_individual_year($month_id, $year_id) 
    {
      $result = 0;
      $result_year = 0;
      $year = Year::find($year_id);
      if($month_id >= 1 && $month_id <= 3)
        $result_year = $year->end_year;
      else
        $result_year = $year->start_year;

      $result = Individual_year::where("individual_year", $result_year)->first();
      return $result->id;
    }

    public static function get_short_year($year_id) 
    {
      $result = 0;
      $result_year = 0;      
      $result = Individual_year::where("individual_year", $year_id)->first();
      if($result)
          return $result->short;
      else
        return 0;
    }


    public static function get_opening_balance($user_id, $year_id) 
    {
      $result = 0;
      $result_year = 0;      
      $result = Opening_balance::where("user_id", $user_id)->where("year_id", $year_id)->first();
      if($result)
          return $result->balance;
      else
        return 0;
    }
}
