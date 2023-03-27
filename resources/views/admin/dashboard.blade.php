@extends('admin.layouts.app')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">#XRS-45670</small>
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <div class="d-flex align-items-center py-1">
                <!--begin::Wrapper-->
                <div class="me-4">
                    لوحه التحكم
                </div>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <div class="card card-xxl-stretch">
                        <div class="card-header border-0 bg-danger py-5">
                            <h3 class="card-title fw-bolder text-white">احصائيات</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="mixed-widget-2-chart card-rounded-bottom bg-danger" data-kt-color="danger" style="height: 200px"></div>
                            <div class="card-p mt-n20 position-relative">
                                <div class="row g-0">
                                    <div class="col-3 bg-light-warning px-6 py-8 rounded-2 me-5 mb-7" style="width: 23%;">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
                                                <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
                                                <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
                                                <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
                                            </svg>

                                        </span>
                                        <a href="{{route('admin.users.index')}}" class="text-warning fw-bold fs-6">العملاء {{$users}}</a>
                                    </div>
                                    <div class="col-3 bg-light-primary px-6 py-8 rounded-2 me-5 mb-7" style="width: 23%;">
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black" />
                                                <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black" />
                                            </svg>
                                        </span>
                                        <a href="{{route('admin.orders.index')}}" class="text-primary fw-bold fs-6">الطلبات الاونلاين {{$online_orders}}</a>
                                    </div>
                                    <div class="col-3 bg-light-danger px-6 py-8 rounded-2 me-5 mb-7" style="width: 23%;">
                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                                            </svg>
                                        </span>
                                        <a href="{{route('admin.orders.index')}}" class="text-danger fw-bold fs-6 mt-2">الطلبات المباشره {{$direct_orders}}</a>
                                    </div>
                                    <div class="col-3 bg-light-success px-6 py-8 rounded-2 me-5 mb-7" style="width: 23%;">
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="black" />
                                                <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="black" />
                                            </svg>
                                        </span>
                                        <a href="{{route('admin.receipts.index')}}" class="text-success fw-bold fs-6 mt-2">فواتير الشراء {{$receipts}}</a>
                                    </div>
                                    <div class="col-3 bg-light-info px-6 py-8 rounded-2 me-5 mb-7" style="width: 23%;">
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="black" />
                                                <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="black" />
                                            </svg>
                                        </span>
                                        <a href="{{route('admin.complaints.index')}}" class="text-success fw-bold fs-6 mt-2"> الشكاوى العامه {{$complaints}}</a>
                                    </div>
                                    <div class="col-3 bg-light-danger px-6 py-8 rounded-2 me-5 mb-7" style="width: 23%;">
                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="black" />
                                                <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="black" />
                                            </svg>
                                        </span>
                                        <a href="{{route('admin.product-complaints')}}" class="text-danger fw-bold fs-6"> شكاوى الطلبات {{$product_complaints}}</a>
                                    </div>



                                </div>
                                <div class="row g-0">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div class="card card-xxl-stretch">
                        <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
                            <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
                                <div class="me-2">
                                    <span class="fw-bolder text-gray-800 d-block fs-3">المبيعات</span>
                                </div>
                                <div class="fw-bolder fs-3 text-primary">{{$amount_of_orders}} جنيه</div>
                            </div>
                            <div class="mixed-widget-10-chart" data-kt-color="primary" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        var initMixedWidget10 = function() {
        var charts = document.querySelectorAll('.mixed-widget-10-chart');

        var color;
        var height;
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseLightColor;
        var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');
        var baseColor;
        var options;
        var chart;
        var completed_orders_count = new Array();
        var completed_orders_labels = new Array();
        var completed_orders = @json($completed_orders);
        completed_orders_labels.push('يناير','فبراير','مارس','ابريل','مايو','يونيو','يوليو','اغسطس'
                ,'سبتمبر','اكتوبر','نوفمبر','ديسمبر');

        let months_array = [{month : 'January' , orders_sum : 0 },{month :'February',orders_sum : 0 }
                    ,{month :'March',orders_sum : 0 },{ month :'April',orders_sum : 0 }
                    ,{month :'May',orders_sum : 0 },{month :'June',orders_sum : 0 }
                    ,{month :'July',orders_sum : 0 },{month :'August',orders_sum : 0 }
                    ,{month :'September',orders_sum : 0 },{month :'October',orders_sum : 0 }
                    ,{month :'November',orders_sum : 0 },{month :'December',orders_sum : 0 }];

        let array_completed_orders = months_array.map(arr1=> ({...arr1, ...completed_orders.find(arr2 => arr2.month === arr1.month)}))

        completed_orders_count = array_completed_orders.map(function(order) {
            return order.orders_sum;
        });

        [].slice.call(charts).map(function(element) {
            color = element.getAttribute("data-kt-color");
            height = parseInt(KTUtil.css(element, 'height'));
            baseColor = KTUtil.getCssVariableValue('--bs-' + color);
            options = {
                series: [{
                    name: 'Net Profit',
                    data: completed_orders_count
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: ['50%'],
                        borderRadius: 4
                    },
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: completed_orders_labels,
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    y: 0,
                    offsetX: 0,
                    offsetY: 0,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                fill: {
                    type: 'solid'
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return "جنيه" + val + "ايرادات"
                        }
                    }
                },
                colors: [baseColor, secondaryColor],
                grid: {
                    padding: {
                        top: 10
                    },
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            chart = new ApexCharts(element, options);
            chart.render();
        });
    }
    </script>
@endsection
