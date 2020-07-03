`@extends('layouts.app')
@section('title', 'Proof Sheet')
@push('styles')
<link href="{{ asset('datatables/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">   
.kt-portlet--mobile
{
    overflow-x:auto !important;
} 
.table 
{
    font-size: 12px !important;
}  
</style>
@endpush
@section('content')

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
                                          Proof Sheet            
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
        <form class="" method="post" action="{{url('proof_sheet')}}">
        {{ csrf_field() }}
            <div class="form-group row">

                    <label for="example-text-input" class="col-2 col-form-label">Select Division</label>
                    <div class="col-3">
                        <select class="form-control" id="division" name="division">
                        <option value="" >Select Division</option>    
                         @foreach($divisions as $rowd )                            
                                <option value="{{$rowd->id}}" <?php if(isset($_POST['division']) && $_POST['division']==$rowd->id) echo "selected"; ?> >{{$rowd->division_name}}</option>
                        @endforeach 
                    </select>
                    </div>
                
                    
                <label for="example-text-input" class="col-2 col-form-label">Select Year</label>
                <div class="col-3">
                    <select class="form-control" id="year" name="year" >
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
            Proof Sheet
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
    <div class="kt-portlet__head-actions">
           @if($year_data)
                <a target="_new" href="{{ url('print_proof_sheet/'.$_POST['division'].'/'.$_POST['year']) }}" class="btn btn-success">Print</a>
           @endif
    </div>  
</div>      </div>
    </div>

<div class="kt-portlet__body">
        <!-- <input type="button" onclick="tableToExcel('table_excel', 'Contribution')" value="Export to Excel"> -->
        <!--begin: Datatable -->

    @if($year_data)
        <table class="table table-striped- table-bordered table-hover table-checkable">
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
                $open_bal = App\Helpers\Helper::get_opening_balance($row->user_id, $_POST['year']);

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
                <td>Total as per Schedule</td>
                <td></td>
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
