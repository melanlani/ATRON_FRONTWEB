<!DOCTYPE html>
<html>
<head>
    @include('template.head')
</head>
<body>
    <div class="loader"></div>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        @include('template.navbar')
        <div class="app-main">        
            @include('template.sidebar')
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @include('template.inner') 
                    @include('table.page_group')
                    @include('table.allocc')                  
                </div>
                @include('template.footer') 
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{ asset('/assets/scripts/jquery.js') }}"></script>
<script src="{{ asset('/assets/scripts/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/scripts/jquery.dataTables.js') }}" ></script>
<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut(3000);
    });

    $(document).ready(function(){

        // $('#allocc').DataTable( {});

        $("#filter_reg").on('change', function()
        {
        var value = $(this).val();
            $.ajax({
                url: '{{ URL::route("dashboard.filter") }}',
                type: 'GET',
                data: 'treg='+value,
                beforeSend: function(){
                    $(".loader").show();
                },
                success:function(data)
                {
                    $("#tablefilter").html(data);
                },
                complete:function(data){
                    // Hide image container
                    $(".loader").hide();
                }
            });
        }); 
 
    });
    function getURL(page) {
        $.ajax({
            url: '{{ URL::route("dashboard.pagination") }}',
            type: 'GET',
            data: 'page='+page,
            beforeSend:function()
            {
              $(".loader").show();
            },
            success:function(data)
            {
              $("#tabs-eg-77").html(data);
            },
            complete:function(data){
                // Hide image container
                $(".loader").hide();
            }
        });
    }

    

</script>
</body>
</html>