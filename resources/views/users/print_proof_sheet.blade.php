<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

#customers td, #customers th {
  border: 1px solid #000;
  padding: 5px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 4px;
  padding-bottom: 4px;
  text-align: left;
  background-color: #ddd;
  color: #000;
}
.total
{
    border:1px solid #000;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 12px;
    padding: 5px;
    width: 30%;
    margin-top:5px;
}
.sign
{
    /*border-top:1px solid #000;*/
    border-bottom:1px solid #000;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 12px;
    padding: 5px;
    width: 100%;
    height: 50px;
    margin-top: 10px;
}
.heading{
    font-size: 13px;
    font-weight: 600;
}
</style>
<center>
    <p class="heading">U.P. Power Sector Employee Trust.F Sheet Register<br>
    General Providend Fund Proof Sheet Register </p>
</center>
@if($year_data)
    <table class="table table-striped- table-bordered table-hover table-checkable" id="customers">
        <thead>
            <tr>
                <td colspan="6">Zone Name: Lucknow Electricity Supply</td>    
                <td colspan="6" rowspan="2">Financial Year: {{$selected_year->short}}</td> 
                <td colspan="5">GPF Category: Operating</td>   
            </tr>
            <tr>  
                <td colspan="6">Unit Name: {{$selected_division['division_name']}}</td>    
                <td colspan="6">Report Date: <?php echo date("d/m/Y"); ?></td>   
            </tr>
           
            <tr>
                <th>Sr. No.</th>
                <th>A/C No.<br>Name of Employee<br>Designation</th>
                <th>Open Bal<br>INT. Earned<br>Closing Bal.</th>
                <th>REF</th>   
                @foreach($month as $rowm)
                <th> {{ $rowm->short }} - 
                @if($rowm->number>3)
                    {{ App\Helpers\Helper::get_short_year($selected_year->start_year)}}
                @else
                    {{ App\Helpers\Helper::get_short_year($selected_year->end_year)}}
                @endif
                </th>
                @endforeach
                <th>Total</th> 
            </tr>
        </thead>
        <tbody>
            <?php $sn=1;
            $total_diff_t = 0; 
            $total_contri = 0;
            $total_withd = 0;
            $total_arrear = 0;
            $$total_diff_t = 0;
            $total_april_contri_total = 0;
            $total_april_withd_total = 0;

            $total_may_contri_total = 0;
            $total_may_withd_total = 0;

            $total_june_contri_total = 0;
            $total_june_withd_total = 0;

            $total_july_contri_total = 0;
            $total_july_withd_total = 0;

            $total_aug_contri_total = 0;
            $total_aug_withd_total = 0;

            $total_sep_contri_total = 0;
            $total_sep_withd_total = 0;

            $total_oct_contri_total = 0;
            $total_oct_withd_total = 0;

            $total_nov_contri_total = 0;
            $total_nov_withd_total = 0;

            $total_dec_contri_total = 0;
            $total_dec_withd_total = 0;

            $total_jan_contri_total = 0;
            $total_jan_withd_total = 0;

            $total_feb_contri_total = 0;
            $total_feb_withd_total = 0;

            $total_march_contri_total = 0;
            $total_march_withd_total = 0;

            $total_contri_total = 0;
            $total_withd_total = 0;
             ?>
            @foreach($year_data as $row)
            <?php 
            $open_bal = App\Helpers\Helper::get_opening_balance($row->user_id, $selected_year->id);

            $apr_contri = $row->april_contri+$row->april_arrear;
            $total_apr_diff = $apr_contri-$row->april_withd;    
            $progressive_apr_amount =  $open_bal+$total_apr_diff;
            $roi_apr_amount = round(($progressive_apr_amount)*$row->april_roi/1200,2);


            $may_contri = $row->may_contri+$row->may_arrear;
            $total_may_diff = $total_apr_diff+ $may_contri-$row->may_withd;    
            $progressive_may_amount =  $open_bal+$total_may_diff;
            $roi_may_amount = round(($progressive_may_amount)*$row->may_roi/1200,2);


            $june_contri = $row->june_contri+$row->june_arrear;
            $total_june_diff = $total_may_diff + $june_contri-$row->june_withd;    
            $progressive_june_amount =  $open_bal+$total_june_diff;
            $roi_june_amount = round(($progressive_june_amount)*$row->june_roi/1200,2);


            $july_contri = $row->july_contri+$row->july_arrear;
            $total_july_diff = $total_june_diff + $july_contri-$row->july_withd;    
            $progressive_july_amount =  $open_bal+$total_july_diff;
            $roi_july_amount = round(($progressive_july_amount)*$row->july_roi/1200,2);


            $aug_contri = $row->aug_contri+$row->aug_arrear;
            $total_aug_diff = $total_july_diff + $aug_contri-$row->aug_withd;    
            $progressive_aug_amount =  $open_bal+$total_aug_diff;
            $roi_aug_amount = round(($progressive_aug_amount)*$row->aug_roi/1200,2);


            $sep_contri = $row->sep_contri+$row->sep_arrear;
            $total_sep_diff = $total_aug_diff + $sep_contri-$row->sep_withd;    
            $progressive_sep_amount =  $open_bal+$total_sep_diff;
            $roi_sep_amount = round(($progressive_sep_amount)*$row->sep_roi/1200,2);


            $oct_contri = $row->oct_contri+$row->oct_arrear;
            $total_oct_diff = $total_sep_diff + $oct_contri-$row->oct_withd;    
            $progressive_oct_amount =  $open_bal+$total_oct_diff;
            $roi_oct_amount = round(($progressive_oct_amount)*$row->oct_roi/1200,2);


            $nov_contri = $row->nov_contri+$row->nov_arrear;
            $total_nov_diff = $total_oct_diff + $nov_contri-$row->nov_withd;    
            $progressive_nov_amount =  $open_bal+$total_nov_diff;
            $roi_nov_amount = round(($progressive_nov_amount)*$row->nov_roi/1200,2);


            $dec_contri = $row->dec_contri+$row->dec_arrear;
            $total_dec_diff = $total_nov_diff + $dec_contri-$row->dec_withd;    
            $progressive_dec_amount =  $open_bal+$total_dec_diff;
            $roi_dec_amount = round(($progressive_dec_amount)*$row->dec_roi/1200,2);


            $jan_contri = $row->jan_contri+$row->jan_arrear;
            $total_jan_diff = $total_dec_diff + $jan_contri-$row->jan_withd;    
            $progressive_jan_amount =  $open_bal+$total_jan_diff;
            $roi_jan_amount = round(($progressive_jan_amount)*$row->jan_roi/1200,2);


            $feb_contri = $row->feb_contri+$row->feb_arrear;
            $total_feb_diff = $total_jan_diff + $feb_contri-$row->feb_withd;    
            $progressive_feb_amount =  $open_bal+$total_feb_diff;
            $roi_feb_amount = round(($progressive_feb_amount)*$row->feb_roi/1200,2);


            $march_contri = $row->march_contri+$row->march_arrear;
            $total_march_diff = $total_feb_diff + $march_contri-$row->march_withd;    
            $progressive_march_amount =  $open_bal+$total_march_diff;
            $roi_march_amount = round(($progressive_march_amount)*$row->march_roi/1200,2);

            $total_roi = $roi_apr_amount 
                        +$roi_may_amount 
                        +$roi_june_amount 
                        +$roi_july_amount 
                        +$roi_aug_amount 
                        +$roi_sep_amount
                        +$roi_oct_amount 
                        +$roi_nov_amount 
                        +$roi_dec_amount 
                        +$roi_jan_amount 
                        +$roi_feb_amount 
                        +$roi_march_amount; 

            $total_contri = $row->april_contri+$row->may_contri+$row->june_contri+$row->july_contri+$row->aug_contri+$row->sep_contri+$row->oct_contri+$row->nov_contri+$row->dec_contri+$row->jan_contri+$row->feb_contri+$row->march_contri;

            $total_withd = $row->april_withd+$row->may_withd+$row->june_withd+$row->july_withd+$row->aug_withd+$row->sep_withd+$row->oct_withd+$row->nov_withd+$row->dec_withd+$row->jan_withd+$row->feb_withd+$row->march_withd;

            $total_arrear = $row->april_arrear+$row->may_arrear+$row->june_arrear+$row->july_arrear+$row->aug_arrear+$row->sep_arrear+$row->oct_arrear+$row->nov_arrear+$row->dec_arrear+$row->jan_arrear+$row->feb_arrear+$row->march_arrear;

            $total_diff_t = $total_contri+$total_arrear-$total_withd;

            $closing = $open_bal+$total_roi+$total_diff_t;

            $total_april_contri_total = $total_april_contri_total+$row->april_contri;
            $total_april_withd_total = $total_april_withd_total+$row->april_withd;

            $total_may_contri_total = $total_may_contri_total+$row->may_contri;
            $total_may_withd_total = $total_may_withd_total+$row->may_withd;

            $total_june_contri_total = $total_june_contri_total+$row->june_contri;
            $total_june_withd_total = $total_june_withd_total+$row->june_withd;

            $total_july_contri_total = $total_july_contri_total+$row->july_contri;
            $total_july_withd_total = $total_july_withd_total+$row->july_withd;

            $total_aug_contri_total = $total_aug_contri_total+$row->aug_contri;
            $total_aug_withd_total = $total_aug_withd_total+$row->aug_withd;

            $total_sep_contri_total = $total_sep_contri_total+$row->sep_contri;
            $total_sep_withd_total = $total_sep_withd_total+$row->sep_withd;

            $total_oct_contri_total = $total_oct_contri_total+$row->oct_contri;
            $total_oct_withd_total = $total_oct_withd_total+$row->oct_withd;

            $total_nov_contri_total = $total_nov_contri_total+$row->nov_contri;
            $total_nov_withd_total = $total_nov_withd_total+$row->nov_withd;

            $total_dec_contri_total = $total_dec_contri_total+$row->dec_contri;
            $total_dec_withd_total = $total_dec_withd_total+$row->dec_withd;

            $total_jan_contri_total = $total_jan_contri_total+$row->jan_contri;
            $total_jan_withd_total = $total_jan_withd_total+$row->jan_withd;

            $total_feb_contri_total = $total_feb_contri_total+$row->feb_contri;
            $total_feb_withd_total = $total_feb_withd_total+$row->feb_withd;

            $total_march_contri_total = $total_march_contri_total+$row->march_contri;
            $total_march_withd_total = $total_march_withd_total+$row->march_withd;

            $total_contri_total = $total_april_contri_total
                                  +$total_may_contri_total
                                  +$total_june_contri_total
                                  +$total_july_contri_total
                                  +$total_aug_contri_total
                                  +$total_sep_contri_total
                                  +$total_oct_contri_total
                                  +$total_nov_contri_total
                                  +$total_dec_contri_total
                                  +$total_jan_contri_total
                                  +$total_feb_contri_total
                                  +$total_march_contri_total;

            $total_withd_total = $total_april_withd_total
                                  +$total_may_withd_total
                                  +$total_june_withd_total
                                  +$total_july_withd_total
                                  +$total_aug_withd_total
                                  +$total_sep_withd_total
                                  +$total_oct_withd_total
                                  +$total_nov_withd_total
                                  +$total_dec_withd_total
                                  +$total_jan_withd_total
                                  +$total_feb_withd_total
                                  +$total_march_withd_total;

            ?>
            <tr>
            <td>{{ $sn }}</td>
            <td><?php echo $row->account_no."<br>".$row->name."<br>".$row->designation ?></td>
            <td>{{ $open_bal }}
                <br>
                {{$total_roi}}
                <br>
                {{$closing}}
            </td>
            <td>CONT<br>ROI<br><!-- TOT<br> -->WITH</td>
            <td>{{ $row->april_contri?$row->april_contri:"0.00" }} 
                <br> {{ $row->april_roi?$row->april_roi:"0.00" }} 
                <!-- <br> {{ $row->april_contri+$row->april_roi }}  -->
                <br> {{ $row->april_withd?$row->april_withd:"0.00" }}
            </td>
            <td>{{ $row->may_contri?$row->may_contri:"0.00" }} 
                <br> {{ $row->may_roi?$row->may_roi:"0.00" }} 
               <!--  <br> {{ $row->may_contri+$row->may_roi }}  -->
                <br> {{ $row->may_withd?$row->may_withd:"0.00" }}
            </td>
            <td>{{ $row->june_contri?$row->june_contri:"0.00" }} 
                <br> {{ $row->june_roi?$row->june_roi:"0.00" }} 
                <!-- <br> {{ $row->june_contri+$row->june_roi }}  -->
                <br> {{ $row->june_withd?$row->june_withd:"0.00" }}
            </td>
            <td>{{ $row->july_contri?$row->july_contri:"0.00" }} 
                <br> {{ $row->july_roi?$row->july_roi:"0.00" }} 
                <!-- <br> {{ $row->july_contri+$row->july_roi }}  -->
                <br> {{ $row->july_withd?$row->july_withd:"0.00" }}
            </td>
            <td>{{ $row->aug_contri?$row->aug_contri:"0.00" }} 
                <br> {{ $row->aug_roi?$row->aug_roi:"0.00" }} 
                <!-- <br> {{ $row->aug_contri+$row->aug_roi }}  -->
                <br> {{ $row->aug_withd?$row->aug_withd:"0.00" }}
            </td>
            <td>{{ $row->sep_contri?$row->sep_contri:"0.00" }} 
                <br> {{ $row->sep_roi?$row->sep_roi:"0.00" }} 
                <!-- <br> {{ $row->sep_contri+$row->sep_roi }}  -->
                <br> {{ $row->sep_withd?$row->sep_withd:"0.00" }}
            </td>
            <td>{{ $row->oct_contri?$row->oct_contri:"0.00" }} 
                <br> {{ $row->oct_roi?$row->oct_roi:"0.00" }} 
                <!-- <br> {{ $row->oct_contri+$row->oct_roi }}  -->
                <br> {{ $row->oct_withd?$row->oct_withd:"0.00" }}
            </td>
            <td>{{ $row->nov_contri?$row->nov_contri:"0.00" }} 
                <br> {{ $row->nov_roi?$row->nov_roi:"0.00" }} 
                <!-- <br> {{ $row->nov_contri+$row->nov_roi }}  -->
                <br> {{ $row->nov_withd?$row->nov_withd:"0.00" }}
            </td>
            <td>{{ $row->dec_contri?$row->dec_contri:"0.00" }} 
                <br> {{ $row->dec_roi?$row->dec_roi:"0.00" }} 
                <!-- <br> {{ $row->dec_contri+$row->dec_roi }}  -->
                <br> {{ $row->dec_withd?$row->dec_withd:"0.00" }}
            </td>
            <td>{{ $row->jan_contri?$row->jan_contri:"0.00" }} 
                <br> {{ $row->jan_roi?$row->jan_roi:"0.00" }} 
                <!-- <br> {{ $row->jan_contri+$row->jan_roi }}  -->
                <br> {{ $row->jan_withd?$row->jan_withd:"0.00" }}
            </td>
            <td>{{ $row->feb_contri?$row->feb_contri:"0.00" }} 
                <br> {{ $row->feb_roi?$row->feb_roi:"0.00" }} 
                <!-- <br> {{ $row->feb_contri+$row->feb_roi }}  -->
                <br> {{ $row->feb_withd?$row->feb_withd:"0.00" }}
            </td>
            <td>{{ $row->march_contri?$row->march_contri:"0.00" }} 
                <br> {{ $row->march_roi?$row->march_roi:"0.00" }} 
                <!-- <br> {{ $row->march_contri+$row->march_roi }}  -->
                <br> {{ $row->march_withd?$row->march_withd:"0.00" }}
            </td>                
            <td>{{$total_contri}}<br>-<br>{{$total_withd }}</td>
        </tr>
            <?php $sn++; ?>
            @endforeach
        <tr>
                <td></td>
                <td>Total as per Schedule</td>
                <td></td>
                <td>CON <br> WITH</td>
                <td>{{$total_april_contri_total}}.00 <br> {{$total_april_withd_total}}.00</td>
                <td>{{$total_may_contri_total}}.00 <br> {{$total_may_withd_total}}.00</td>
                <td>{{$total_june_contri_total}}.00 <br> {{$total_june_withd_total}}.00</td>
                <td>{{$total_july_contri_total}}.00 <br> {{$total_july_withd_total}}.00</td>
                <td>{{$total_aug_contri_total}}.00 <br> {{$total_aug_withd_total}}.00</td>
                <td>{{$total_sep_contri_total}}.00 <br> {{$total_sep_withd_total}}.00</td>
                <td>{{$total_oct_contri_total}}.00 <br> {{$total_oct_withd_total}}.00</td>
                <td>{{$total_nov_contri_total}}.00 <br> {{$total_nov_withd_total}}.00</td>
                <td>{{$total_dec_contri_total}}.00 <br> {{$total_dec_withd_total}}.00</td>
                <td>{{$total_jan_contri_total}}.00 <br> {{$total_jan_withd_total}}.00</td>
                <td>{{$total_feb_contri_total}}.00 <br> {{$total_feb_withd_total}}.00</td>
                <td>{{$total_march_contri_total}}.00 <br> {{$total_march_withd_total}}.00</td>
                <td>{{$total_contri_total}} <br> {{ $total_withd_total }}</td>
            </tr>
        </tbody>
    </table>
@endif

    <div class="sign">
        <div style="width: 100%; margin-top: 25px;"></div>
        <div style="width: 33%; float: left;">
            <center>ASSTT. ACCTT.<br>ZAO [LESA], LUCKNOW</center>
        </div>
        <div style="width: 33%; float: left;">
            <center> ACCOUNTANT<br>ZAO [LESA], LUCKNOW</center>
        </div>
        <div style="width: 33%; float: left;">
            <center>ASSISTANT ACCOUNTS OFFICER/ACCOUNTS OFFICER<br>ZAO [LESA], LUCKNOW</center>
        </div>
    </div>