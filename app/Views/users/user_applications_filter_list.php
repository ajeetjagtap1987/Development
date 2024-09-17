
<?php 
use App\Models\CommonModel;
$CommonModel = new CommonModel();
        if(count( $paginateData ) > 0 ) {
            echo '<div class="table-responsive">';
            echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                    <tr>
                                          <th width='5%'>Sr No.</th>
                                      
                                          <th>Application Name</th>
                                          <th width='10%'>Created Date</th>
                                          <th width='3%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
            $i=0;                    
            foreach( $paginateData as $user_app ){
                $encrypter = \Config\Services::encrypter();
                $e_id=bin2hex($encrypter->encrypt($user_app['id']));
                $convert_time = $CommonModel->converToTz($user_app['created_date']);
                $category =  $CommonModel->getDataById($table_name='category',$user_app['category_id']);
                $category_name= count($category)>0 ? $category[0]['category_name'] : '';
                $i++;
                echo "<tr>";
                echo "<td>".$i."</td>";
                
                echo "<td>".$user_app['name']."</td>";
                // if($user_app['status'] == ACTIVE){
                //     echo "<td>Active</td>";
                // }else{
                //     echo "<td>Inactive</td>";
                // }
                echo "<td nowrap>".$convert_time."</td>";
                echo "<td nowrap>";
               echo "<button class='btn btn-icon btn-sm btn-danger' title='Edit' onclick='revokeApplication(".$user_app['id'].")'><i class='ti ti-arrow-back-up'></i></button>";
                echo "</td>";
                echo"</tr>";
            }
            echo "</tbody></table>";
            echo '</div>';
            // echo '<div class="card-footer d-flex align-items-center">';
            // echo $pager->links('default', 'boostrap_pagination');
            // echo '</div>';
        } else {
            echo '<div class="shadow-none p-3 bg-light rounded text-center"><h4 class="text-center" style="margin: revert;">Data Not Found</h4></div>';   
        }
?>