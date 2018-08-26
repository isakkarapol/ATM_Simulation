<div class="row">
    <div class="col-xl-12">
        <div class="m-portlet m-portlet--full-height">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a onclick="Dashboard.functionCall('profitShare', 'Today');" class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget2_tab1_content" role="tab">
                                Today
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a onclick="Dashboard.functionCall('profitShare', 'Week');" class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget2_tab2_content1" role="tab">
                                Week
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a onclick="Dashboard.functionCall('profitShare', 'Month');" class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget2_tab3_content1" role="tab">
                                Month
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a onclick="Dashboard.functionCall('profitShare', 'All');" class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget2_tab3_content1" role="tab">
                                All
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="m_widget2_tab1_content">
                        <div class="row m-row--no-padding m-row--col-separator-xl">
                            <div class="col-xl-6">
                                <div class="m-widget1" id="dashboard_row_jobs"> </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="m-widget14">
                                    <div class="row  align-items-center">
                                        <div class="col">
                                            <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">
                                                <div class="m-widget14__stat" id="dashboard_pie_jobs_count">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="m-widget14__legends" id="dashboard_pie_jobs_div"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Page Snippets--> 
<script src="<?php echo base_url("assets/js/template/dashboard.js") ?>" type="text/javascript"></script>
<!--end::Page Snippets -->