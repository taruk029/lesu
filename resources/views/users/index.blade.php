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
    
    <div class="row">
     <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
        <form class="" method="post" action="{{url('employees')}}">
        {{ csrf_field() }}
            <div class="form-group row">

                    <label for="example-text-input" class="col-2 col-form-label">Select Division</label>
                    <div class="col-3">
                        <select class="form-control" id="division" name="division">
                        <option value="" >Select Division</option>    
                         @foreach($divisions as $rowd )                            
                                <option value="{{$rowd->id}}" <?php if(isset($_POST['division']) && $_POST['division']==$rowd->id) echo "selected"; ?> >{{$rowd->division_code}} - {{$rowd->division_name}}</option>
                        @endforeach 
                    </select>
                    </div>
                
                    
                <label for="example-text-input" class="col-2 col-form-label">Select Employee Type</label>
                <div class="col-3">
                    <select class="form-control" id="emp_type" name="emp_type" >
                        <option value="" >Select Employee Type</option>    
                        <option value="1" <?php if(isset($_POST['emp_type']) && $_POST['emp_type']==1) echo "selected"; ?> >Ministirial</option>
                        <option value="2" <?php if(isset($_POST['emp_type']) && $_POST['emp_type']==2) echo "selected"; ?> >Operating</option>
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
                <i class="kt-font-brand fa fa-building"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                Employee List
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
    <div class="kt-portlet__head-actions">
        <!--<div class="dropdown dropdown-inline">
        <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="la la-download"></i> Export   
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <ul class="kt-nav">
                    <li class="kt-nav__section kt-nav__section--first">
                        <span class="kt-nav__section-text">Choose an option</span>
                    </li>
                    <li class="kt-nav__item">
                        <a href="#" class="kt-nav__link">
                            <i class="kt-nav__link-icon la la-print"></i>
                            <span class="kt-nav__link-text">Print</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a href="#" class="kt-nav__link">
                            <i class="kt-nav__link-icon la la-copy"></i>
                            <span class="kt-nav__link-text">Copy</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a href="#" class="kt-nav__link">
                            <i class="kt-nav__link-icon la la-file-excel-o"></i>
                            <span class="kt-nav__link-text">Excel</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a href="#" class="kt-nav__link">
                            <i class="kt-nav__link-icon la la-file-text-o"></i>
                            <span class="kt-nav__link-text">CSV</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a href="#" class="kt-nav__link">
                            <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                            <span class="kt-nav__link-text">PDF</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
-->        &nbsp;
        <a href="{{ url('add_employee')}}" class="btn btn-brand btn-elevate btn-icon-sm">
            <i class="la la-plus"></i>
            Add New Employee
        </a>
    </div>  
</div>      </div>
    </div>

    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Employee</th>
                    <th>Employee Type</th>
                    <th>Division</th>
                    <th>Account Type</th>
                    <th>Account No.</th>
                    <th>Designsation</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                @foreach($users as $row )
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $row->employee_name  }}</td>
                    <td>@if($row->employee_type==1)
                            {{"Ministirial "}}
                        @else
                            {{"Operating "}}
                        @endif
                    </td>
                    <td>{{ $row->division_code." - ".$row->division_name  }}</td>
                    <td>@if($row->account_type==1) {{ "GPF" }} @else {{ "CPF" }} @endif </td>
                    <td>{{ $row->account_no  }}</td>
                    <td>{{ $row->designation  }}</td>
                    <td>{{ $row->phone?$row->phone:"N/A"  }}</td>
                    <td>
                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" href="{{url('edit_employee/'.$row->user_id)}}" title="Edit Employee Details" >
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_new" href="{{url('monthly_contribtuion/'.$row->user_id)}}" title="Add Monthly Contribution" >
                            <i class="fa fa-rupee-sign"></i>
                        </a>
                    </td>
                </tr>
              <?php $i++; ?>  
            @endforeach                
            </tbody>
        </table>
        <!--end: Datatable -->
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
