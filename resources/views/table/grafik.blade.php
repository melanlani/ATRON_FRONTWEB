<div class="row">
    <div class="col-md-12">
        <div class="mb-3 card" id="grafik">
            <div class="card-header-tab card-header-tab-animation card-header">
                <div class="card-header-title">
                    Grafik {{$site_name}}({{$site_id}})
                </div>
                <ul class="nav">
                    <li class="nav-item"><a class="active nav-link" id="day">A day</a></li>
                    <li class="nav-item"><a class="nav-link" id="week" onclick="getURL('<?php echo $site_name; ?>', '<?php echo $site_id; ?>')">A week</a></li>
                    <li class="nav-item"><a class="nav-link second-tab-toggle" id="month">A month</a></li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-eg-77">
                        <div class="card mb-3 widget-chart widget-chart2 text-left w-100">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                                    <div id="container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>