`@extends('layouts.app')
@section('title', 'Add Employee')
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
                                            Add Employee                    
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
        <div class="kt-portlet col-12">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                       Add New Employee
                    </h3>
                </div>
            </div>
            <!--begin::Form-->
                <form class="kt-form kt-form--label-right" method="post" enctype="multipart/form-data" action="{{url('add_employee')}}">
                     {{ csrf_field() }}
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
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Name" required>
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
                                <option value="1">GPF</option>
                                <option value="2">CPF</option>
                                
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
                            <input class="form-control" type="text" name="account_no" value="{{ old('account_no') }}" id="account_no" placeholder="Employees Account No." onblur="javascript:check_account_no()">
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
                                        <option value="{{$row->id}}">{{$row->designation}}</option>
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
                                <option value="1">Ministirial</option>
                                <option value="2">Operating</option>
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
                                        <option value="{{$rowd->id}}">{{$rowd->division_code." - ".$rowd->division_name}}</option>
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
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" id="email" placeholder="Employees Email">
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
                            <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" id="phone" placeholder="Mobile" onkeypress="return NumbersOnly(event,this)" maxlength="10">
                             <span class="form-text" style="color:red">
                                @if ($errors->has('phone'))
                                    <strong>{{ $errors->first('phone') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Employees Password </label>
                        <div class="col-10">
                            <input class="form-control" type="password" name="password" value="" id="password" placeholder="Password">
                             <span class="form-text" style="color:red">
                                @if ($errors->has('password'))
                                    <strong>{{ $errors->first('password') }}</strong>
                                @endif
                            </span>
                        </div>
                    </div>   -->    
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
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
</div>
<!--End::Section-->
<!--End::Dashboard 8--> 
</div>
    <!-- end:: Content -->
@endsection

<script>
    function check_account_no(){

        var account_type = $("#account_type").val();
        var account_no = $("#account_no").val();
        if(account_type!="" && account_no!="")
        {
            $.blockUI({ message: "<i class='fa fa-2x fa-spinner fa-spin' aria-hidden='true' ></i> &nbsp; <h6>Loading... a moment please.</h6>" });
            $.ajax({
                url: "{{ url('check_account_no') }}",
                type: 'GET',
                data: {account_no:account_no, account_type:account_type},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                        if(data==1)
                        {
                            alert("This acoount number is already assigned to other employee.");
                            $("#account_no").val('');
                        }
                    
                    $.unblockUI();
                }
            });
        }
        else
        {
            alert("Please select account type.");
            $("#account_type").focus();
        }
    }
</script>