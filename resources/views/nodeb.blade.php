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
                    @include('table.addmocc')                  
                </div>
                @include('template.footer') 
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{ asset('/assets/scripts/jquery.js') }}"></script>
<script src="{{ asset('/assets/scripts/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/scripts/jquery.dataTables.js') }}" ></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#allocc').DataTable({});
        $('#occreg').DataTable({});

        $("#regional").on('change', function()
        {
            if($(this).val() != ''){
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                $.ajax({
                    url: '{{ URL::route("nodeb.witel") }}',
                    type: 'GET',
                    data: 'treg='+value,
                    success:function(data)
                    {
                        $("#witel").html(data);
                    }
                });   
            }
        
        });
    });

</script>
</body>
</html>