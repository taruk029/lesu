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
                <label for="example-text-input" class="col-2 col-form-label">Employee Name</label>
                <div class="col-3">
                   <input class="form-control" type="text" readonly="readonly" name="name" value="{{$user->employee_name}}" id="name" placeholder="Employee Name">
                   <input class="form-control" type="hidden" name="emp_id" value="{{$user->user_id}}" id="emp_id" placeholder="Employee Name">
                </div>
                <label for="example-text-input" class="col-2 col-form-label">Account Type & No.</label>
                <div class="col-3">
                   <input class="form-control" type="text" readonly="readonly" name="name" value="<?php if($user->account_type==1) echo "GPF"; else echo "CPF"; ?> - {{$user->account_no}}" id="name" placeholder="Employee Name">
                   <input class="form-control" type="hidden" name="emp_id" value="{{$user->user_id}}" id="emp_id" placeholder="Employee Name">
                </div>
                </div>
                <div class="form-group row">
                <label for="example-text-input" class="col-2 col-form-label">Division</label>
                <div class="col-3">
                   <input class="form-control" type="text" readonly="readonly" name="name" value="{{$user->division_name.' - '.$user->division_code}}" id="name" placeholder="Employee Name">
                   <input class="form-control" type="hidden" name="emp_id" value="{{$user->user_id}}" id="emp_id" placeholder="Employee Name">
                </div>
                <label for="example-text-input" class="col-2 col-form-label">Opening Balance</label>
                <div class="col-3">
                   <input class="form-control"  type="text" name="opening_balance" value="{{ $open_bal }}" id="opening_balance" placeholder="Opening Balance" required="required">
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
                <label for="example-text-input" class="col-2 col-form-label">Rate Of Interest</label>
                <div class="col-3">
                   <input class="form-control" type="text" name="interest" value="{{ $rate_oi }}" id="interest" placeholder="Rate Of Interest" onblur="javascript:add_rate()">
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
           
    </div>  
</div>      </div>
    </div>

    <div class="kt-portlet__body">
       <!--  <input type="button" onclick="tableToExcel('table_excel', 'Contribution')" value="Export to Excel"> -->
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="table_excel">
            <thead>
                <tr>
                    <th>Month</th>    
                    <th>Contribution</th>    
                    <th>Arrear</th>    
                    <th>Rate Of Interest</th>    
                    <th>Withdrawl</th> 
                    <th>Total Contribution</th> 
                    <th>Division</th> 
                    <th>Remark</th> 
                </tr>
            </thead>
                   
            <tbody>
                @if($year_data)
                    @foreach($year_data as $rowd)
                    <tr>
                       <td>{{$rowd->month}} - {{$rowd->indi_year}}</td> 
                       <td>
                        <input type="text" maxlength="10" data-id="{{$rowd->id}}" id="contri{{$rowd->id}}" onkeypress="return isDecimal(event,this)" onblur="javascript:save_contri_data( {{ $rowd->id }},1, this )" value="{{$rowd->contribution}}" style=" height: 31px; width: 140px; padding: 10px;">
                        </td>
                        <td>
                        <input type="text" maxlength="10" data-id="{{$rowd->id}}" id="arrear{{$rowd->id}}" onkeypress="return isDecimal(event,this)" onblur="javascript:save_contri_data( {{ $rowd->id }},5, this )" value="{{$rowd->arrear}}" style=" height: 31px; width: 140px; padding: 10px;">
                        </td> 
                        <td>
                            <input type="text" maxlength="10" data-id="{{$rowd->id}}" id="roi{{$rowd->id}}" onkeypress="return isDecimal(event,this)" onblur="javascript:save_contri_data( {{$rowd->id }} , 2, this )" class="rate_of_interest_class" value="{{$rowd->rate_of_interest}}" style=" height: 31px; width: 140px; padding: 10px;">
                        </td> 
                        <td>
                            <input type="text" maxlength="10" data-id="{{$rowd->id}}" id="withdrawl{{$rowd->id}}" onkeypress="return isDecimal(event,this)" onblur="javascript:save_contri_data( {{ $rowd->id }}, 3, this )" value="{{$rowd->withdrawl}}" style=" height: 31px; width: 140px; padding: 10px;">
                        </td> 
                        <td>
                            <input type="text" maxlength="10" data-id="{{$rowd->id}}" id="total{{$rowd->id}}" onkeypress="return isDecimal(event,this)" readonly="readonly" value="{{$rowd->total}}" style=" height: 31px; width: 140px; padding: 10px;" >
                        </td> 
                        <td>
                            <select class="form-control" id="divisions" name="divisions" onchange="javascript:save_contri_data({{$rowd->id }},4, this )">
                                <option value="">Select Divisions</option>
                                @if($divisions)
                                    @foreach($divisions as $rowdd)
                                        <option <?php if($rowd->division_id==$rowdd->id) echo "selected "; else { if($rowd->division_id==$rowdd->id) echo "selected "; } ?> value="{{$rowdd->id}}">{{$rowdd->division_code." - ".$rowdd->division_name}}</option>
                                    @endforeach
                                @endif
                        </select>
                        </td> 
                        <td>
                            <input type="text" data-id="{{$rowd->id}}" id="total{{$rowd->id}}" value="{{$rowd->remark}}" onblur="javascript:save_contri_data( {{ $rowd->id }}, 6, this )" style=" height: 31px; width: 140px; padding: 10px;" >
                        </td>
                    </tr> 
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

    function get_open_bal()
        {
            var year = $('#year').val();
            var emp_id = $("#emp_id").val();
            $('#opening_balance').val('');
            if(year)
            {   
            $.ajax({
                url: "{{ url('get_open_bal') }}",
                type: 'GET',
                data: {emp_id:emp_id, year:year},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    if(data!="false")
                    {
                        datas = JSON.parse(data);
                        $('#opening_balance').val(datas['open']);
                        $('#interest').val(datas['roi']);
                    }
                    else
                    {
                        $('#opening_balance').val('');
                        $('#interest').val('');
                    }
                }
            });
        }
        else
        {
            alert("Please select year first.");
            $("#year").focus();
        }
        }

    function save_contri_data(id, type, sender){

        var vals = sender.value;
        var emp_id = $("#emp_id").val();
        var year = $("#year").val();
        var contri = $('#contri'+id).val();
        if(type!=6)
        {
            if(contri=="" || contri==0)
            {
                contri = 0;
            }
            var arrear = $('#arrear'+id).val();
            if(arrear=="" || arrear==0)
            {
                arrear = 0;
            }
            var roi = $('#roi'+id).val();
            if(roi=="" || roi==0)
            {
                roi = 0;
            }
            var withdrawl = $('#withdrawl'+id).val();
            if(withdrawl=="" || withdrawl==0)
            {
                withdrawl = 0;
            }
            var total_val = (parseInt(contri)+parseInt(arrear))-parseInt(withdrawl);
            if(total_val<0)
            {
                total_val = "0.00";
            }
            
            $('#total'+id).val(total_val);
            if(vals!="" && emp_id!="")
            {
                $.ajax({
                    url: "{{ url('save_contri_data') }}",
                    type: 'GET',
                    data: {emp_id:emp_id, id:id, type:type, value:vals,  total_val:total_val,   year:year },            
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                       console.log("data saved.");
                       if(type==2)
                       {
                        location.reload();
                       }
                    }
                });
            }
        }
        else
        {
            if(vals!="" && emp_id!="")
                {
                    $.ajax({
                        url: "{{ url('save_contri_data') }}",
                        type: 'GET',
                        data: {emp_id:emp_id, id:id, type:type, value:vals,  total_val:total_val,   year:year  },            
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                           console.log("data saved.");
                        }
                    });
                }
        }
        
        
    }
</script>
