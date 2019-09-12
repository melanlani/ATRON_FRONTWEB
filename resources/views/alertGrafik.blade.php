<!DOCTYPE html>
<html>
<head>
    @include('template.head')
</head>
<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        @include('template.navbar')
        <div class="app-main">        
            @include('template.sidebar')
            <div class="app-main__outer">
                <div class="app-main__inner">  
                    @include('table.grafik')                  
                </div>
                @include('template.footer') 
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{ asset('/assets/scripts/jquery.js') }}"></script>
<script src="{{ asset('/assets/scripts/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/scripts/jquery.dataTables.js') }}" ></script>
<script src="http://code.highcharts.com/highcharts.src.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){

    });
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'NODE B OCCUPANCY GRAPHICS'
            },
            subtitle: {
                text: '24 Hours'
            },
            xAxis: {
                categories: ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00']
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
                name: 'UP',
                data: [1,2,8,12,5,2,5,9,10,6],
                color: '#3ac47d'

            }]
        });
    });

</script>
</body>
</html>