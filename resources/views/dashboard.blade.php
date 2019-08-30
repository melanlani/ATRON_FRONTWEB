<!DOCTYPE html>
<html>
<head>
    @include('template.head')
</head>
<body>
    <div class="loader"></div>
    <div id="overlay"><div><img src="{{ asset('/assets/images/atron/loading2.gif') }}" width="64px" height="64px"/></div></div>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        @include('template.navbar')
        <div class="app-main">        
            @include('template.sidebar')
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @include('template.inner')    
                    <div class="row">
                        @include('table.allstat')  
                        @include('table.occ_reg')  
                    </div> 
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
                    $("#overlay").show();
                },
                success:function(data)
                {
                    $("#table2").html(data);
                },
                complete:function(data){
                    // Hide image container
                    $("#overlay").hide();
                }
            });
            $.ajax({
                url: '{{ URL::route("dashboard.filter_inner") }}',
                type: 'GET',
                data: 'treg='+value,
                beforeSend:function()
                {   
                    $("#grandtotal").html('Please wait...')
                },
                success:function(data)
                {
                    $("#grandtotal").html(data);
                },
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
              $("#tabs-eg-77").html('Please wait...')
            },
            success:function(data)
            {
              $("#tabs-eg-77").html(data);
            },
        });
    }

    

</script>
</body>
</html>