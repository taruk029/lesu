`@extends('layouts.app')
@section('title', 'Monthly Contribution')
@push('styles')
<link href="{{ asset('datatables/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<style type="text/css">
    .kt-portlet--mobile
{
    overflow-x:auto !important;
    sc
}
</style>
<!-- begin:: Subheader -->
                            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                                <div class="kt-subheader__main">

                                    <h3 class="kt-subheader__title">
                                        Dashboard
                                    </h3>

                                    <span class="kt-subheader__separator kt-hidden"></span>
                                    <div class="kt-subheader__breadcrumbs">
                                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                        <span class="kt-subheader__breadcrumbs-separator"></span>
                                        <a href="#" class="kt-subheader__breadcrumbs-link">
                                           Monthly Contribution                   
                                        </a>
                                         
                                </div>
                                    </div>

                                <div class="kt-subheader__toolbar">
                                    <div class="kt-subheader__wrapper">
                                        <a href="#" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Today is <?php echo date("d-m-Y"); ?>" data-placement="left">
                                            <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
                                            <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date("M d"); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end:: Subheader -->
                            
    <!-- begin:: Content -->
    <div class="kt-content kt-grid__item kt-grid__item--fluid" id="kt_content">
        <!--Begin::Dashboard 8-->
<div class="row">
     <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
        <form class="" method="post" action="{{Request::url()}}">
        {{ csrf_field() }}
            <div class="form-group row">

                    <label for="example-text-input" class="col-2 col-form-label">Select Account Type</label>
                    <div class="col-3">
                        <select class="form-control" id="account_type" name="account_type" required="required">
                                    <option value="">Select Account Type</option>
                                    <option value="1" <?php if(isset($_POST['account_type']) && $_POST['account_type']==1) echo "selected"; ?>>GPF</option>
                                    <option value="2" <?php if(isset($_POST['account_type']) && $_POST['account_type']==2) echo "selected"; ?>>CPF</option>
                                    
                            </select>
                    </div>
                
                    <label for="example-text-input" class="col-2 col-form-label">Account No.</label>
                    <div class="col-3">
                       <input class="form-control" type="text" name="acc_num" id="acc_num" placeholder="Account Number" value="<?php if(isset($_POST['acc_num'])) echo $_POST['acc_num']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                
                <label for="example-text-input" class="col-2 col-form-label">Year</label>
                <div class="col-3">
                    <select class="form-control" id="year" name="year" onchange="javascript:get_open_bal()">
                        <option value="" >Select Year</option>    
                         @foreach($years as $row )                            
                                <option value="{{$row->id}}" <?php if(isset($_POST['year']) && $_POST['year']==$row->id) echo "selected"; ?> >{{$row->short}}</option>
                        @endforeach 
                    </select>
                </div>
                </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    </div>
</div>
<!--Begin::Section-->
<div class="row">
     <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon-clipboard"></i>
            </span>
            <h3 class="kt-portlet__head-title">
               Monthly Contribution
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
    <div class="kt-portlet__head-actions">
           @if($year_data)
                <a target="_new" href="{{ url('print_indi_view/'.$user['user_id'].'/'.$_POST['year']) }}" class="btn btn-success">Print</a>
           @endif
    </div>  
</div>      </div>
    </div>

    <div class="kt-portlet__body">
        <!-- <input type="button" onclick="tableToExcel('table_excel', 'Contribution')" value="Export to Excel"> -->
        <!--begin: Datatable -->
</table>
        <table class="table table-striped- table-bordered table-hover table-checkable" id="table_excel">
            <thead>
                @if($user)
                <tr>
                    <td colspan="5">Name: {{ $user['employee_name'] }}</td>    
                    <td colspan="5">Unit Name: {{ $user['division_code']."-".$user['division_name'] }}</td>  
                </tr>
                <tr>
                    <td colspan="5">Designation: {{ $user['designation'] }}</td>    
                    <td colspan="5">Opening Balance: {{ $open['balance'] }}</td>  
                </tr>
                <tr>
                    <td colspan="10">Account Number: {{ $user['account_no'] }}</td>    
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
                    <th>
                    </th> 
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
                <?php  $total_diff_t = 0; ?>
                <?php  $sn = 1; ?>

                    @foreach($year_data as $rowtotal)
                        <?php $total_contri_t = $rowtotal->contribution+$rowtotal->arrear;
                        $progressive_t = $open['balance'];
                        $total_diff_t = $total_diff_t + $total_contri_t-$rowtotal->withdrawl;
                        $progressive_amount_t = $progressive_t+$total_diff_t;
                        $roi_amount_t = round(($progressive_amount_t)*$rowtotal->rate_of_interest/1200,2);
                        
                        $total_contribution = $total_contribution+$rowtotal->contribution;
                        $total_arrear = $total_arrear +$rowtotal->arrear;
                        $total_total = $total_total +$total_contri_t;
                        $total_withdraw = $total_withdraw +$rowtotal->withdrawl;
                        $total_progressive = $total_progressive +$progressive_amount_t;
                        $total_roi = $total_roi +$roi_amount_t;
                        ?>
                    @endforeach 

                    @foreach($year_data as $rowd)
                    <?php $total_contri = $rowd->contribution+$rowd->arrear;
                    $progressive = $open['balance'];
                    $total_diff = $total_diff + $total_contri-$rowd->withdrawl;
                    $progressive_amount = $progressive+$total_diff;
                    $roi_amount = round(($progressive_amount)*$rowd->rate_of_interest/1200,2);
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
                    @if($sn==1)
                    <td rowspan="12">
                        Details of the Total Amount
                        <br><br><br><br>
                        Op Bal 1st Apr &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$progressive_t}}
                        <br><br>
                        Cot & Ref. Amt. &nbsp;&nbsp;&nbsp;{{$total_total.".00"}}
                        <br><br>
                        Int.  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$total_roi}}
                        <br><br>
                        Total  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $t = $progressive_t+$total_total+$total_roi;
                                echo $t; ?>
                        <br><br>
                        Withdrawl  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;{{$total_withdraw.".00"}}
                        <br><br>
                        Balance &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $b = $t-$total_withdraw;
                                echo $b; ?>
                        
                    </td>
                    @endif
                </tr>
                    <?php  $sn++; ?>
                    @endforeach 
                
                @endif 
            </tbody>
        </table>
        <!--end: Datatable -->
      <!--   <div class="col-12" >
            <button type="submit" class="btn btn-success" style="float: right;">Submit GPF Data</button>
        </div> -->
    </div>
</div>
</div>
<!--End::Section-->
<!--End::Dashboard 8--> 
</div>
    <!-- end:: Content -->
@endsection
@push('scripts')
<script src="{{ asset('datatables/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('datatables/assets/js/demo8/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
<!--end::Page Scripts -->

@endpush

<script type="text/javascript">
    function add_rate()
    {
        var interest = $('#interest').val()
        $('.rate_of_interest_class').val(interest);
        var emp_id = $("#emp_id").val();
        var year = $("#year").val();
        if(year)
         {   
        $.ajax({
            url: "{{ url('save_roi_data') }}",
            type: 'GET',
            data: {emp_id:emp_id, year:year, value:interest, },            
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
               console.log("data saved.");
            }
        });
    }
    else
    {
        alert("Please select year first.");
        $("#year").focus();
    }
    }    
</script>
