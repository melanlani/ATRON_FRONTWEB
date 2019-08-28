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

        $('#alertocc').DataTable( {});

        $("#filter_reg").on('change', function()
        {
        var value = $(this).val();
            $.ajax({
                url: '{{ URL::route("dashboard.filter") }}',
                type: 'GET',
                data: 'treg='+value,
                beforeSend:function()
                {   
                    $("#table2").html('Please wait...')
                },
                success:function(data)
                {
                    $("#table2").html(data);
                },
            });
            $.ajax({
                url: '{{ URL::route("dashboard.filter_inner") }}',
                type: 'GET',
                data: 'treg='+value,
                beforeSend:function()
                {   
                    $("#totcritical").html('Please wait...')
                },
                success:function(data)
                {
                    $("#totcritical").html(data);
                },
            });
        }); 

        // $(".btn-submitNext").click(function(e){
        //     e.preventDefault();
        //     var row = $("input[name=row]").val();
        //     var total = 500;

        //     value = 10 + 1;
        //     if( value < total ){
        //         row = value;
        //     }
        //     $.ajax({
                
        //         success:function(data)
        //         {
        //           alert(row);
        //         },
        //     });
        // });

        $("button").click(function(){
            var page = $(this).val();
            $.ajax({
                url: '{{ URL::route("dashboard.pagination") }}',
                type: 'GET',
                data: 'page='+page,
                beforeSend:function()
                {
                  $("#table3").html('Please wait...')
                },
                success:function(data)
                {
                  $("#table3").html(data);
                },
            });
        });
    });

    

</script>
</body>
</html>