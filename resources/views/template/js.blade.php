<script src="<?php echo base_url('assets/scripts/main.js') ?>"></script>

<script>
  $(document).ready(function(){

    $("#filter_reg").on('change', function()
    {
    var value = $(this).val();
      $.ajax(
      {
        url: 'filter.php',
        type: 'POST',
        data: 'request='+value,
        beforeSend:function()
        {
          $("#table-container").html('Working On...')
        },
        success:function(data)
        {
          $("#table-container").html(data);
        },
      });
      $.ajax(
      {
        url: 'filter2.php',
        type: 'POST',
        data: 'request='+value,
        beforeSend:function()
        {
          $("#table-containers").html('Working On...')
        },
        success:function(data)
        {
          $("#table-containers").html(data);
        },
      });
    });
    $('#up').click(function(){
      $.ajax(
      {
        url: 'up.php',
        type: 'POST',
        data: 'up='+50,
        beforeSend:function()
        {
          $("#table-status").html('Working On...')
        },
        success:function(data)
        {
          $("#table-status").html(data);
        },
      });
    });
    $('#down').click(function(){
      $.ajax(
      {
        url: 'down.php',
        type: 'POST',
        data: 'down='+50,
        beforeSend:function()
        {
          $("#table-status").html('Working On...')
        },
        success:function(data)
        {
          $("#table-status").html(data);
        },
      });
    });
  });
</script>