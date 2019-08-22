<table class="table table-striped" id="allstat">
  <thead>
  <tr>
      <th class="text-center">Witel</th>
      <th class="text-center"><div class="badge badge-success">UP</div></th>
      <th class="text-center"><div class="badge badge-danger">Down</div></th>
      <th class="text-center">Total</th>
  </tr>
  </thead>
  <tbody>
      <?php 
          $total_up = 0;
          $total_down = 0;
          $total=0;
          foreach ($stat as $item) { 
          $sub_total = $item->up + $item->down;
      ?>
      <tr>
          <td class="text-center"><?php echo $item->city; ?></td>
          <td class="text-center"><?php echo $item->up; ?></td>
          <td class="text-center"><?php echo $item->down; ?></td>
          <td class="text-center"><?php echo $sub_total; ?></td>
      </tr>
      <?php
          $total_up += $item->total_up; 
          $total_down += $item->total_down;
          $total += $sub_total;
          } 
      ?>
  </tbody>
  <tfoot>
      <tr>
          <th class="text-center">Total</th>
          <th class="text-center"><?php echo $total_up; ?></th>
          <th class="text-center"><?php echo $total_down; ?></th>
          <th class="text-center"><?php echo $total; ?></th>
      </tr>
  </tfoot>
</table>