
<?php
use App\Models\CommonModel;
$CommonModel = new CommonModel();
        if(count( $paginateData ) > 0 ) {
            echo '<div class="table-responsive">';
            echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                    <tr>
                                          <th width='5%'>Id</th>
                                          <th>Asset Id</th>
                                          <th>Model Name</th>
                                          <th width='20%'>Created Date</th>
                                          <th width='5%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table' id='refresh_table'>";
            foreach( $paginateData as $assets ){
                $encrypter = \Config\Services::encrypter();
                $e_id=bin2hex($encrypter->encrypt($assets['id']));
                $convert_time = $CommonModel->converToTz($assets['created_date']);
                echo "<tr>";
                echo "<td>".$assets['id']."</td>";
                echo "<td><a href='".base_url()."/assets/details/".$e_id."'  title='View' target='_blank'>".$assets['asset_id']."</a</td>";
                echo "<td>".$assets['model_name']."</td>";
                // if($assets['status'] == ACTIVE){
                //     echo "<td>Active</td>";
                // }else{
                //     echo "<td>Inactive</td>";
                // }
                echo "<td nowrap>".$convert_time."</td>";
                echo "<td nowrap>";
                echo "<a href='".base_url()."/assets/edit/".$e_id."' class='btn btn-icon btn-sm btn-primary'  title='Edit' target='_blank'><i class='ti ti-edit'></i></a>";

                echo "<button class='btn btn-icon btn-sm btn-danger' title='Edit' onclick='deleteAssets(" .$assets['id'] . ")'><i class='ti ti-trash'></i></button>";

                echo "</td>";
                echo"</tr>";
            }
            echo "</tbody></table>";
            echo '</div>';
            echo '<div class="card-footer d-flex align-items-center">';
            echo 'Total Count - '.$pager->getTotal();

            echo $pager->links('default', 'boostrap_pagination');
            echo '</div>';
        } else {
            echo '<div class="shadow-none p-3 mb-5 bg-light rounded text-center"><h4 class="text-center" style="margin: revert;">Data Not Found</h4></div>';
        }
?>