
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
                                     
                                          <th width='70px'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
            foreach( $paginateData as $category ){
                $encrypter = \Config\Services::encrypter();
                $e_id=bin2hex($encrypter->encrypt($category['id']));
                $convert_time = $CommonModel->converToTz($category['created_date']);
                echo "<tr>";
                echo "<td>".$category['id']."</td>";
                echo "<td>".$category['category_name']."</td>";
                echo "<td>";
                foreach (CATEGORY_TYPE as $key => $value) {
                    if($category['category_type'] == $key){
                         echo $value;
                    }
                }
                echo "</td>";
                echo "<td>".$category['user_assign_limit']."</td>";
                
                if($category['status'] == ACTIVE){
                    echo "<td>Active</td>";
                }else{
                    echo "<td>Inactive</td>";
                }
                echo "<td nowrap>".$convert_time."</td>";
                echo "<td nowrap>";
                echo "<a href='".base_url()."/category/edit/".$e_id."' class='btn btn-icon btn-sm btn-primary' title='Edit'><i class='ti ti-edit'></i></a>";
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