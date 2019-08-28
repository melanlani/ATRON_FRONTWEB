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
                    <div id="dialog-confirm"></div>  
                    @include('table.adduser')                  
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

        $('#alluser').DataTable({});

    });

    function myFunction() {
        confirm("Are you sure you want to delete this?");
    }

</script>
</body>
</html>