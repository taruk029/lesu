`@extends('layouts.app')

@section('content')
<!-- begin:: Subheader -->
                            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                                <div class="kt-subheader__main">

                                    <h3 class="kt-subheader__title">
                                        Dashboard
                                    </h3>

                                    <!--<span class="kt-subheader__separator kt-hidden"></span>
                                    <div class="kt-subheader__breadcrumbs">
                                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                        <span class="kt-subheader__breadcrumbs-separator"></span>
                                        <a href="#" class="kt-subheader__breadcrumbs-link">
                                            Application                    
                                        </a>
                                         <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> 
                                </div>-->
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
    <div class="kt-portlet">
    <div class="kt-portlet__body  kt-portlet__body--fit">
        
    </div>
</div>
</div>
<!--End::Section-->


<!--End::Dashboard 8--> </div>
    <!-- end:: Content -->
@endsection
@push('scripts')
<!--begin::Page Vendors(used by this page) -->
<script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/gmaps/gmaps.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo8/pages/dashboard.js') }}" type="text/javascript"></script>
<!--end::Page Scripts -->
@endpush

