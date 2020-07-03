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
    border-top:1px solid #000;
    border-bottom:1px solid #000;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 12px;
    padding: 5px;
    width: 100%;
    height: 50px;
}
.heading{
    font-size: 13px;
    font-weight: 600;
}
</style>
<center>
    <p class="heading">Office of DY. Chief Accounts Officer<br>
    Zonal Accounts Office, Lesa<br>
    SIS Gomti, Lucknow<br>
    GPF Account Slip For F.Y. {{$years['short']}}
    </p>
</center>
<table class="table table-striped- table-bordered table-hover table-checkable" id="customers">
<thead>
    @if($user)
    <tr>
        <td colspan="5">Name: {{ $user['employee_name'] }}</td>    
        <td colspan="4">Unit Name: {{ $user['division_code']."-".$user['division_name'] }}</td>  
    </tr>
    <tr>
        <td colspan="5">Designation: {{ $user['designation'] }}</td>    
        <td colspan="4">Opening Balance: {{ $open['balance'] }}</td>  
    </tr>
    <tr>
        <td colspan="5">Account Number: {{ $user['account_no'] }}</td>    
    </tr>
    @endif
    <tr>
        <th>Month</th>    
        <th>Contribution</th>    
        <th>Arrear</th>    
        <th>Total</th>   
        <th>Withdrawl</th>  
        <th>Progressive</th> 
        <th>Rate Of Interest</th> 
        <th>Amount</th> 
        <th>Remarks If Any</th> 
    </tr>
</thead>
<tbody>

    @if($year_data)
    <?php  $total_contribution = 0; ?>
    <?php  $total_arrear = 0; ?>
    <?php  $total_total = 0; ?>
    <?php  $total_progressive = 0; ?>
    <?php  $total_withdraw = 0; ?>
    <?php  $total_roi = 0; ?>
    <?php  $total_diff = 0; ?>

        @foreach($year_data as $rowd)
        <?php $total_contri = $rowd->contribution+$rowd->arrear;
        $progressive = $open['balance'];
        $total_diff = $total_diff + $total_contri-$rowd->withdrawl;
        $progressive_amount = $progressive+$total_diff;
        $roi_amount = round(($progressive_amount)*$rowd->rate_of_interest/1200,2);
        
        $total_contribution = $total_contribution+$rowd->contribution;
        $total_arrear = $total_arrear +$rowd->arrear;
        $total_total = $total_total +$total_contri;
        $total_withdraw = $total_withdraw +$rowd->withdrawl;
        $total_progressive = $total_progressive +$progressive_amount;
        $total_roi = $total_roi +$roi_amount;
        //$amount=round((($progressive+$total_contri-$rowd->withdrawl)*$rowd->rate_of_interest)/100,2);
        ?>

    <tr>
        <td>{{$rowd->month}} - {{$rowd->indi_year}}</td>
        <td>{{$rowd->contribution?$rowd->contribution:"0.00"}}</td>
        <td>{{$rowd->arrear?$rowd->arrear:"0.00"}}</td>
        <td>{{$total_contri.".00"}}</td>
        <td>{{$rowd->withdrawl?$rowd->withdrawl:"0.00"}}</td>
        <td>{{$progressive_amount}}</td>
        <td>{{$rowd->rate_of_interest}}</td>
        <td>{{$roi_amount}}</td>
        <td>{{$rowd->remark}}</td>
    </tr>
        @endforeach 
    <tr>
        <td>Total</td>
        <td>{{$total_contribution.".00"}}</td>
        <td>{{$total_arrear.".00"}}</td>
        <td>{{$total_total.".00"}}</td>
        <td>{{$total_withdraw.".00"}}</td>
        <td>{{$total_progressive.".00"}}</td>
        <td></td>
        <td>{{$total_roi}}</td>
        <td></td>
    </tr>
    @endif 
    <div >
        <table class="total"> 
            <tr>
                <td>CLOSING BALANCE - YEAR</td>
                <td align="left" >{{$years['short']}}</td>
            </tr>
            <tr>
                <td>OPENING BALANCE</td>
                <td align="right" >{{ $open['balance'] }}</td>
            </tr>
            <tr>
                <td>TOTAL DEPOSIT</td>
                <td align="right" >{{$total_total.".00"}}</td>
            </tr>
            <tr>
                <td>TOTAL EARNED INTEREST</td>
                <td align="right" >{{$total_roi}}</td>
            </tr>
            <tr>
                <td>SUBTOTAL</td>
                <td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <?php $t = $open['balance']+$total_total+$total_roi; echo $t; ?>
                </td>
            </tr>
            <tr>
                <td>TOTAL WITHDRAWL</td>
                <td align="right" >{{$total_withdraw.".00"}}</td>
            </tr>
            <tr>
                <td>TOTAL ADDITIONAL INTEREST</td>
                <td align="right" >0.00</td>
            </tr>
            <tr>
                <td>TOTAL ADDITIONAL AMOUNT</td>
                <td align="right" >0.00</td>
            </tr>
            <tr>
                <td>CLOSING BALANCE AS ON</td>
                <td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <?php $b = $t-$total_withdraw; echo $b; ?>
                </td>
            </tr>
        </table>
    </div>
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
    <div style="width: 50%; float: left; margin-top: 10px;"><span style='font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; font-size: 12px;'> <strong>Note:</strong> In case of any error, please report with in 15 days.</span>
    </div>
    <div style="width: 50%; float: left; margin-top: 10px;">
       <span style='font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; font-size: 12px;float: right;'>  Date: <?php echo date('d/m/Y'); ?></span>
    </div>
</tbody>
</table>
    