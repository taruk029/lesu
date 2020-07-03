`@extends('layouts.app')
@section('title', 'Employee')
@push('styles')
<link href="{{ asset('datatables/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
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
                                            Employee List                    
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
<!--Begin::Section-->
<div class="row">
     <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
        
        <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Employee Name</label>
                        <div class="col-3">
                           <label style="margin-top: 10px;"> {{ $user_details->first_name." ".$user_details->last_name }}</label>
                        </div>
                        <label for="example-text-input" class="col-2 col-form-label">Quarter</label>
                        <div class="col-3">
                           <label style="margin-top: 10px;"> {{ $quarter->quarter." - (".$quarter->start_date." to ".$quarter->end_date.")" }}</label>
                        </div>
                    </div>
    </div>
</div>
</div>
<!--End::Section-->

<!--Begin::Section-->
<div class="row">
     <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand fa fa-building"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Enter Skill Rating
                </h3>
            </div>
        </div>

    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <h3 class="kt-portlet__head-title">
            Skill
        </h3>
        <label class="kt-font-danger alert"></label>
        <table class="table table-striped- table-bordered table-hover table-checkable" >
            <thead>
                <tr>
                    <th>Skill</th>
                    <th>Rating</th>
                    <th>Success</th>
                </tr>
            </thead>

            <tbody>
                @foreach($emp_rating as $row )
                    <tr>
                        <td>{{ $row->skill  }}</td>
                        <td>
                            <input type="text" maxlength="2" placeholder="0-10" data-id="{{$row->skill_id}}" id ="rate{{$row->skill_id}}" onkeypress="return NumbersOnly(event,this)" onblur="javascript:save_rating(this)" value="{{$row->rating}}" style=" height: 41px; width: 100px; padding: 10px;"> / 10
                           
                        </td>
                        <td>
                             <span title="Rating has been saved successfully." id="check{{$row->skill_id}}" style="display: none;float: right;margin-right: 50%">
                                <span class="kt-badge kt-badge--success kt-badge--xl"> <i class="fa fa-check"></i></span>
                            </span>
                        </td>
                    </tr> 
                @endforeach             
            </tbody>
        </table>
        <label class="kt-font-danger alert"></label>
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
    
    function save_rating(id)
    {
        var user_id = {{ $user_details->user_id }};
        var rating = id.value;
        var quarter_id  = {{ $quarter->id }};
        var data_id = $(id).attr('data-id');
        $("#check"+data_id).css("display", "none");
        var datas = {user_id:user_id , rating:rating , skill_id:data_id, quarter_id:quarter_id};
        if(rating!="")
        {
            if(rating <= 10)
            {
                $.blockUI({ message: "<i class='fa fa-2x fa-spinner fa-spin' aria-hidden='true' ></i> &nbsp; <h6>Loading... a moment please.</h6>" });
                $.ajax({
                    url: "{{ url('save_skill_rating') }}",
                    type: 'GET',
                    data: datas,            
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        if(data==0)
                        {
                            alert("Something went wrong, please try again.");
                            id.value = "";
                        }
                        else
                        {
                            $("#check"+data_id).css("display", "block");
                        }
                        $.unblockUI();
                    }
                });
            }
            else
            {
                $(".alert").html("Please enter ratings between 0-10");
                setTimeout(function(){ $(".alert").html(""); }, 7000);
            }
        }
    }
</script>