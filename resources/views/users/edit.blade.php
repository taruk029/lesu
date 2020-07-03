`@extends('layouts.app')
@section('title', 'Edit Employee')
@push('styles')
<link href="{{ asset('datatables/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<!-- begin:: Subheader -->
                            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                                <div class="kt-subheader__main">

                                    <h3 class="kt-subheader__title">
                                        Employees
                                    </h3>

                                    <span class="kt-subheader__separator kt-hidden"></span>
                                    <div class="kt-subheader__breadcrumbs">
                                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                        <span class="kt-subheader__breadcrumbs-separator"></span>
                                        <a href="#" class="kt-subheader__breadcrumbs-link">
                                            Edit Employee                    
                                        </a>
                                        <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
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
     <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                       Edit Employee
                    </h3>
                </div>
            </div>
            <!--begin::Form-->
                <form class="kt-form kt-form--label-right" method="post" enctype="multipart/form-data" action="{{url('update_employee')}}">
                     {{ csrf_field() }}
                <input class="form-control" type="hidden" name="user_id" value="{{ $user->user_id }}" id="user_id">
                <div class="kt-portlet__body">
                    <div class="form-group form-group-last">
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-icon"><i class="flaticon-alert kt-font-brand"></i></div>
                            <div class="alert-text">
                                Fields marked with <span style="color:red">*</span> are required.
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Name <span style="color:red">*</span></label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="name" value="{{ $user->employee_name }}" id="name" placeholder="Name" required>
                            <span class="form-text" style="color:red">
                                @if ($errors->has('name'))
                                    <strong>{{ $errors->first('name') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Select Account Type<span style="color:red">*</span></label>
                        <div class="col-10">
                            <select class="form-control" id="account_type" name="account_type" required="required">
                                <option value="">Select Account Type</option>
                                <option value="1" <?php if($user->account_type ==1) echo "selected"; ?> >GPF</option>
                                <option value="2"  <?php if($user->account_type ==2) echo "selected"; ?> >CPF</option>
                        </select>
                        <span class="form-text text" style="color:red">
                                @if ($errors->has('account_type'))
                                    <strong>{{ $errors->first('account_type') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Account No.</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="account_no" value="{{ $user->account_no }}" id="account_no" placeholder="Employees Account No.">
                             <span class="form-text" style="color:red">
                                @if ($errors->has('account_no'))
                                    <strong>{{ $errors->first('account_no') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Employee Designation <span style="color:red">*</span></label>
                        <div class="col-10">
                            <select class="form-control" id="designation" name="designation">
                                <option value="">Select Designation</option>
                                @if($designation)
                                    @foreach($designation as $row)
                                        <option <?php if($user->designation_id==$row->id) echo "selected "; ?> value="{{$row->id}}">{{$row->designation}}</option>
                                    @endforeach
                                @endif
                        </select>
                        <span class="form-text text" style="color:red">
                                @if ($errors->has('designation'))
                                    <strong>{{ $errors->first('designation') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Employee Type<span style="color:red">*</span></label>
                        <div class="col-10">
                            <select class="form-control" id="employee_type" name="employee_type">
                                <option value="" >Select Employee Type</option>    
                                <option value="1" <?php if($user->employee_type==1) echo "selected "; ?>>Ministirial</option>
                                <option value="2" <?php if($user->employee_type==2) echo "selected "; ?>>Operating</option>
                            </select>
                        <span class="form-text text" style="color:red">
                                @if ($errors->has('employee_type'))
                                    <strong>{{ $errors->first('employee_type') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Employee Divison <span style="color:red">*</span></label>
                        <div class="col-10">
                            <select class="form-control" id="divisions" name="divisions">
                                <option value="">Select Divisions</option>
                                @if($divisions)
                                    @foreach($divisions as $rowd)
                                        <option <?php if($user->division_id==$rowd->id) echo "selected "; ?> value="{{$rowd->id}}">{{$rowd->division_code." - ".$rowd->division_name}}</option>
                                    @endforeach
                                @endif
                        </select>
                        <span class="form-text text" style="color:red">
                                @if ($errors->has('divisions'))
                                    <strong>{{ $errors->first('divisions') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div> 
                    <div class="form-group row" style="display: hidden;">
                        <label for="example-text-input" class="col-2 col-form-label">Employees Email </label>
                        <div class="col-10">
                            <input class="form-control" type="email" name="email" value="{{ $user->email  }}" id="email" placeholder="Employees Email">
                             <span class="form-text" style="color:red">
                                @if ($errors->has('email'))
                                    <strong>{{ $errors->first('email') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Mobile </label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="phone" value="{{ $user->phone  }}" id="phone" placeholder="Mobile" onkeypress="return NumbersOnly(event,this)" maxlength="10">
                             <span class="form-text" style="color:red">
                                @if ($errors->has('phone'))
                                    <strong>{{ $errors->first('phone') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Employees Image</label>
                        <div class="col-10">
                            <input class="form-control" type="file" name="images">
                             <span class="form-text" style="color:red">
                                @if ($errors->has('images'))
                                    <strong>{{ $errors->first('images') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div> 
                    <div class="form-group row">
                    <label for="example-text-input" class="col-2 col-form-label">Employees Current Image</label>
                    @if(!empty($user->profile_picture)) 
                        @if(file_exists(base_path().'/public/employee_picture/'.$user->profile_picture))
                        <img style=" width: 150px;" src="{{ asset('employee_picture/'.$user->profile_picture) }}" class="img img-thumbnail" >

                        @endif
                        @else
                        <label for="example-text-input" class="col-2 col-form-label">{{"No Image"}}</label>
                    @endif
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Portlet-->
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
<script>
    function get_states(){
        $("#new_country_div").css("display","none");
        $("#state_div").css("display","block");
        var countryid = $("#country").val();
        if(countryid!=32)
        {
            $.blockUI({ message: "<i class='fa fa-2x fa-spinner fa-spin' aria-hidden='true' ></i> &nbsp; <h6>Loading... a moment please.</h6>" });
            $.ajax({
                url: "{{ url('get_states') }}",
                type: 'GET',
                data: {id:countryid},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                   
                    data = JSON.parse(data);
                    var count = Object.keys(data).length;
                    var all = '<option value="">Select State</option>';
                    for (var i = 0; i < count; i++) { 
                        all += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>'; 
                    }
                   
                    $("#state").html(all);
                    $.unblockUI();
                }
            });
        }
        else
        {
            $("#new_country_div").css("display","block");
            $("#state_div").css("display","none");
        }
    }

    function new_department(){
        var departmentid = $("#department").val();

            $.blockUI({ message: "<i class='fa fa-2x fa-spinner fa-spin' aria-hidden='true' ></i> &nbsp; <h6>Loading... a moment please.</h6>" });
            $.ajax({
                url: "{{ url('get_subdepartments') }}",
                type: 'GET',
                data: {id:departmentid},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                   
                    data = JSON.parse(data);
                    var count = Object.keys(data).length;
                    var all = '<option value="">Select Sub-Department</option>';
                    for (var i = 0; i < count; i++) { 
                        if(data[i].id!=10)
                        {
                            all += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>'; 
                        }
                        }
                   
                    $("#subdepartment").html(all);
                    $.unblockUI();
                }
            });
        }

    function kras(){
        var subdepartmentid = $("#subdepartment").val();

            $.blockUI({ message: "<i class='fa fa-2x fa-spinner fa-spin' aria-hidden='true' ></i> &nbsp; <h6>Loading... a moment please.</h6>" });
            $.ajax({
                url: "{{ url('get_department_kra') }}",
                type: 'GET',
                data: {id:subdepartmentid},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                   
                    data = JSON.parse(data);
                    var count = Object.keys(data).length;
                    var all = '';
                    for (var i = 0; i < count; i++) { 
                        if(data[i].id!=10)
                        {
                            all += '<option value="'+ data[i].id +'">'+ data[i].name +'</option>'; 
                        }
                        }
                   
                    $("#kra_list").html(all);
                    $.unblockUI();
                }
            });
        }

    function get_kras()
    {
        var kra_list = [];
        var kra_value = [];
        $.each($("#kra_list option:selected"), function(){            
            kra_list.push('<span>' + $(this).text() + '<i class="fa fa-times-circle" onClick="unselectKRA('+$(this).val()+')" title="Remove KRA" /></span>');
        });
        var list = kra_list.join(", ");
        $("#display_kra").html(list);
    }
    function unselectKRA(id)
    {
        var wanted_option = $('#kra_list option[value="'+ id +'"]');
        wanted_option.prop('selected', false);
        get_kras();
    }

    function get_name()
    {
        $("#display_emp_name").html("");
        var reporting_to = $("#reporting_to").val();
        if(reporting_to!="")
        {
            $.blockUI({ message: "<i class='fa fa-2x fa-spinner fa-spin' aria-hidden='true' ></i> &nbsp; <h6>Loading... a moment please.</h6>" });
            $.ajax({
                url: "{{ url('get_employee_from_code') }}",
                type: 'GET',
                data: {id:reporting_to},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){

                    if(data!="")
                    {
                        $("#display_emp_name").html(data);
                    }
                    $.unblockUI();
                }
            });
        }
    }

</script>