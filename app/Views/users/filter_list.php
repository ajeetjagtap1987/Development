<style>
.table {
   display: table !important;
   border-collapse: collapse !important;
}

.table .table-row {
   display: table-row !important;
}

.table .table-cell {
   display: table-cell !important;
   text-align: left !important;
   vertical-align: top !important;
   border: 1px solid black !important;
}
</style>


<?php
use App\Models\CommonModel;
$CommonModel = new CommonModel();
        if(count( $paginateData ) > 0 ) {
            echo '<div class="table-responsive">';
            echo "<table id='zero_config' class='table  table-striped '>
                                <thead>
                                    <tr>
                                          <th width='5%'>Id</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Job Title</th>
                                          <th width='20%'>Microsoft 365 Business</th>
                                          <th width='10%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
            foreach( $paginateData as $user ){
                $encrypter = \Config\Services::encrypter();
                $u_id=bin2hex($encrypter->encrypt($user['id']));
                if($user['status'] == ACTIVE){
                    $user_email ='<span class="text-green">'.$user['email'].'</span>';
                }else{
                    $user_email ='<span class="text-red">'.$user['email'].'</span>';
                }

                echo "<tr>";
                echo "<td>".$user['id']."</td>";
                echo "<td><a href='".base_url()."/users/details/".$u_id."'title='Detail' target='_blank' >".$user['first_name']." ".$user['last_name']." </a></td>";
                echo "<td>".$user_email."</td>";
                echo "<td>".$user['job_title']."</td>";

                echo "<td nowrap>".$user['microsoft_365_business_licence']."</td>";
                echo "<td nowrap>";

                echo "<a href='".base_url()."/users/details/".$u_id."' class='btn btn-icon btn-sm btn-info' title='Assign' target='_blank'><i class='ti ti-a-b-2'></i></a>";
                if(session('user_type') == ADMIN){
                    if($user['status'] == ACTIVE){

                        echo "<a href='".base_url()."/users/edit/".$u_id."' class='btn btn-icon btn-sm btn-primary' title='Edit' target='_blank'><i class='ti ti-edit'></i></a>";

                        if($user['user_type'] == TECHNICIAN){
                        echo "<a href='".base_url()."/users/change-password/".$u_id."' class='btn btn-icon btn-sm btn-warning' title='Change Password'  target='_blank'><i class='ti ti-key'></i></a>";

                       ?>
                <?php   }
                    }
                }elseif(session('user_type') == TECHNICIAN){
                    if($user['status'] == ACTIVE){
                        echo "<a href='".base_url()."/users/edit/".$u_id."' class='btn btn-icon btn-sm btn-primary' title='Edit' target='_blank'><i class='ti ti-edit'></i></a>";
                    ?>
                    <?php
                    }

                }
                echo "<button class='btn btn-icon btn-sm btn-danger' title='Delete' onclick='deleteUser(" .$user['id'] . ")'><i class='ti ti-trash'></i></button>";

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