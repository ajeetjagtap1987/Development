
<?php
$iteration = 1;
use App\Models\CommonModel;
$CommonModel = new CommonModel();
        if(count( $paginateData ) > 0 ) {
            echo '<div class="table-responsive">';
            echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                    <tr>
                                          <th>Id</th>
                                          <th>Supplier Name</th>
                                          <th width='20%'>Created Date</th>
                                          <th width='5%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
            foreach( $paginateData as $vendor ){
                $encrypter = \Config\Services::encrypter();
                $e_id=bin2hex($encrypter->encrypt($vendor['id']));
                $convert_time = $CommonModel->converToTz($vendor['created_date']);
                echo "<tr>";
                echo "<td>".$iteration."</td>";
                echo "<td><a href='".base_url()."/vendor/view/".$e_id."' title='View'>".$vendor['supplier_name']."</a></td>";
                // if($vendor['status'] == ACTIVE){
                //     echo "<td>Active</td>";
                // }else{
                //     echo "<td>Inactive</td>";
                // }
                echo "<td nowrap>".$convert_time."</td>";
                echo "<td nowrap>";
                echo "<a href='".base_url()."/vendor/edit/".$e_id."' class='btn btn-icon btn-sm btn-primary' title='Edit'><i class='ti ti-edit'></i></a>";
                // echo "<a href='".base_url()."/vendor/gst_list/".$e_id."' class='btn btn-icon btn-sm btn-warning' title='GST Detail'><i class='ti ti-receipt-tax'></i></a>";
                echo "</td>";
                echo"</tr>";
                $iteration ++;
            }
            echo "</tbody></table>";
            echo '</div>';
            echo '<div class="card-footer d-flex align-items-center">';
            echo $pager->links('default', 'boostrap_pagination');
            echo '</div>';
        } else {
            echo '<div class="shadow-none p-3 mb-5 bg-light rounded text-center"><h4 class="text-center" style="margin: revert;">Data Not Found</h4></div>';
        }
?>