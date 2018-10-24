<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Dashboard</a>
            <i class="fa fa-circle"></i>
        </li>
    </ul>

</div>
<!-- END PAGE BAR -->

<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> Last Closed Month
    <small>status</small>
</h1>
<!-- END PAGE TITLE-->

<div class="row">
    <?php
    $color = ['dark', 'blue-madison', 'green-seagreen', 'dark', 'yellow'];
    $rand_keys = array_rand($color, 2);


    $col = 12 / $compTotal->company_entity;
    foreach ($company as $comp) {
        $sql = "SELECT DISTINCT max( gl_date ) AS last_date FROM " . $comp->database . ".gl_header WHERE Fclose= 'close' ORDER BY YEAR ( gl_header.gl_date )";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $date = new DateTime($row->last_date);

        }

        echo '<div class="col-md-' . $col . '">
                       <a class="dashboard-stat dashboard-stat-v2 ' . $color[$rand_keys[0]] . '" href="javascript:;">
                           <div class="visual">
                               <i class="fa fa-close"></i>
                           </div>
                           <div class="details">
                               <div class="number">
                                   <span>' . $date->format('F-Y') . '</span>
                               </div>
                               <div class="desc"> ' . $comp->company_code . ' | ' . $comp->company_name.' </div>
                           </div>
                       </a>
                   </div>';


    }
    ?>

</div>