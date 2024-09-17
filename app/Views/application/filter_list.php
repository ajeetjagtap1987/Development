
<?php
use App\Models\CommonModel;
$CommonModel = new CommonModel();
        if(count( $paginateData ) > 0 ) {
            echo csrf_field();
            echo '<div class="table-responsive">';
            echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                    <tr>
                                          <th>Id</th>
                                          <th>Name</th>
                                          <th>Category</th>
                                          <th  width='20%'>Created Date</th>
                                          <th width='5%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
            foreach( $paginateData as $application ){
                $encrypter = \Config\Services::encrypter();
                $e_id=bin2hex($encrypter->encrypt($application['id']));
                $convert_time = $CommonModel->converToTz($application['created_date']);
                $category =  $CommonModel->getDataById($table_name='category',$application['category_id']);
                $category_name= count($category)>0 ? $category[0]['category_name'] : '';
                echo "<tr>";
                echo "<td>".$application['id']."</td>";
                echo "<td>".$application['name']."</td>";
                echo "<td>".$category_name."</td>";
                // if($application['status'] == ACTIVE){
                //     echo "<td>Active</td>";
                // }else{
                //     echo "<td>Inactive</td>";
                // }
                echo "<td nowrap>".$convert_time."</td>";
                echo "<td nowrap>";
                echo "<a href='".base_url()."/application/edit/".$e_id."' class='btn btn-icon btn-sm btn-primary' title='Edit' target='_blank'><i class='ti ti-edit'></i></a>";
                echo "<button class='btn btn-icon btn-sm btn-danger' title='Edit' onclick='deleteApplication(" .$application['id']. ")'><i class='ti ti-trash'></i></button>";

                echo "</td>";
                echo"</tr>";
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