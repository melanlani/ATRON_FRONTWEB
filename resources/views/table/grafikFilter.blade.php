<div class="card-header-tab card-header-tab-animation card-header">
    <div class="card-header-title">
        Grafik {{$site_name}}({{$site_id}})
    </div>
    <ul class="nav">
        <?php 
            if($filter == 'week'){
        ?>
        <li class="nav-item"><a class="nav-link" id="day" href="{{ route('alert.grafik', ['site_id' => $site_id, 'site_name' => $site_name ]) }}">A day</a></li>
        <li class="nav-item"><a class="active nav-link" id="week">A week</a></li>
        <li class="nav-item"><a class="nav-link second-tab-toggle" id="month">A month</a></li>
        <?php
            }else if($filter == 'day'){
        ?>  
        <li class="nav-item"><a class="active nav-link" id="day">A day</a></li>
        <li class="nav-item"><a class="nav-link" id="week" onclick="getURLDay('<?php echo $site_name; ?>', '<?php echo $site_id; ?>')">A week</a></li>
        <li class="nav-item"><a class="nav-link second-tab-toggle" id="month">A month</a></li>
        <?php
            }
        ?>
        
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

<script type="text/javascript">
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'NODE B OCCUPANCY GRAPHICS'
            },
            subtitle: {
                text: 'One Week'
            },
            xAxis: {
                categories: {!! json_encode($dateOcc) !!}
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Occupancy (%)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Node b',
                data: {!! json_encode($occ) !!},
                color: '#3ac47d'

            }]
        });
    });
    function getURLDay(sitename, siteid) {
        var value = 'day';
        $.ajax({
            url: '{{ URL::route("alert.grafikFilter") }}',
            type: 'GET',
            data: {
                    "site_id": siteid, 
                    "site_name":sitename,
                    "filter":value
                  },
            success:function(data)
            {
              $("#grafik").html(data);
            }
        });
    }
</script>