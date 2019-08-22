<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
</head>
<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php $this->load->view("admin/_partials/navbar.php") ?>
        <div class="app-main">        
            <?php $this->load->view("admin/_partials/sidebar.php") ?>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <?php $this->load->view("admin/_partials/inner.php") ?>
               
                    <div class="row">
                        <div class="col-md-12">            
                            <div class="main-card mb-3 card">
                                <div class="card-header">Data Occupancy
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="tabs-eg-77">
                                            <div class="widget-content p-0">
                                                <table class="table table-striped" id="occreg">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Reg</th>
                                                            <th class="text-center">Witel</th>
                                                            <th class="text-center">Site ID</th>
                                                            <th class="text-center">Site Name</th>
                                                            <th class="text-center">BW</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Current Occupancy</th>
                                                            <th class="text-center">Aging</th>
                                                            <th class="text-center">Today Highest</th>
                                                            <th class="text-center">Weekly Highest</th>
                                                            <th class="text-center">Monthly Highest</th>
                                                            <th class="text-center">Yearly Highest</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach ($reg as $item) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $item->regional; ?></td>
                                                            <td class="text-center"><?php echo $item->city; ?></td>
                                                            <td class="text-center"><a class="btn-transition btn btn-outline-primary" href="<?php echo base_url().'index.php/utilities/stat_total/'.$item->site_id; ?>"><?php echo $item->site_id; ?></a></td>
                                                            <td class="text-center"><?php echo $item->site_name; ?></td>
                                                            <?php
                                                                echo '<td class="text-center">'.$item->bw.'</td>';
                                                            if ($item->status =="up"){
                                                                echo '<td class="text-center"><i class="pe-7s-angle-up-circle icon-gradient bg-malibu-beach" style="font-size:35px"></i></td>';
                                                            } else{      
                                                                echo '<td class="text-center"><i class="pe-7s-angle-down-circle icon-gradient bg-ripe-malin" style="font-size:35px"></i></td>';
                                                            }
                                                            if($item->current >=70){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-danger">'.$item->current.'%</button></td>';
                                                            } 
                                                            else if($item->current  >50){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$item->current.'%</button></td>';
                                                            }
                                                            else if($item->current  <=50){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$item->current.'%</button></td>';
                                                            }

                                                            echo '<td class="text-center">'.$item->aging.'</td>';

                                                            if($item->today_highest >=70){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-danger">'.$item->today_highest.'%</button></td>';
                                                            } 
                                                            else if($item->today_highest >=50){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$item->today_highest.'%</button></td>';
                                                            }
                                                            else if($item->today_highest >=0){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$item->today_highest.'%</button></td>';
                                                            }

                                                            if($item->weekly_highest >=70){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-danger">'.$item->weekly_highest .'%</button></td>';
                                                            } 
                                                            else if($item->weekly_highest  >=50){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$item->weekly_highest .'%</button></td>';
                                                            }
                                                            else if($item->weekly_highest >=0){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$item->weekly_highest .'%</button></td>';
                                                            }

                                                            if($item->monthly_highest >=70){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-danger">'.$item->monthly_highest.'%</button></td>';
                                                            } 
                                                            else if($item->monthly_highest >=50){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$item->monthly_highest.'%</button></td>';
                                                            }
                                                            else if($item->monthly_highest>=0){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$item->monthly_highest.'%</button></td>';
                                                            }

                                                            if($item->yearly_highest >=70){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-danger">'.$item->yearly_highest.'%</button></td>';
                                                            } 
                                                            else if($item->yearly_highest >=50){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$item->yearly_highest.'%</button></td>';
                                                            }
                                                            else if($item->yearly_highest >=0){
                                                                echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$item->yearly_highest.'%</button></td>';
                                                            }
                                                            ?>
                                                        </tr>
                                                        <?php
                                                            } 
                                                        ?>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="<?php echo base_url().'assets/scripts/jquery.js'?>"></script>
<script src="<?php echo base_url('assets/scripts/main.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/scripts/jquery.dataTables.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#occreg').DataTable( {
           
        });
    });
</script>
</body>
</html>

