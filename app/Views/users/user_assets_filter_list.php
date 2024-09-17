
<?php

use App\Models\CommonModel;

$CommonModel = new CommonModel();
if (count($paginateData) > 0) {



    echo '<div class="table-responsive">';
    echo "<table id='zero_config' class='table table-striped'>
                                <thead>
                                    <tr>
                                          <th width='5%'>Sr No.</th>
                                          <th width='5%'>Category Name</th>
                                          <th>Asset Id</th>
                                          <th>Model Name</th>
                                          <th>Serial No</th>
                                          <th width='10%'>Warranty Expiry Date</th>
                                          <th width='5%'>Remaining Days</th>
                                          <th width='10%'>Created Date</th>
                                          <th width='3%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
    $i = 0;
    foreach ($paginateData as $user_asset) {
        $encrypter = \Config\Services::encrypter();
        $e_a_id = bin2hex($encrypter->encrypt($user_asset['a_id']));
        $convert_time = $CommonModel->converToTz($user_asset['created_date']);
        $category =  $CommonModel->getDataById($table_name = 'category', $user_asset['category_id']);
        $category_name = count($category) > 0 ? $category[0]['category_name'] : '';
        $date1 = date_create(date('Y-m-d'));
        $date2 = date_create($user_asset['warranty_expiry_date']);
        if ($date1 < $date2) {
            $diff = date_diff($date1, $date2);
            $wed = $diff->format("%a days");
        } else {
            $wed = '<span class="badge bg-red">Expired</span>';
        }

        $timestamp = strtotime($user_asset['warranty_expiry_date']);
        $ExpiryDate = date('d-M-Y', $timestamp);


        $i++;
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $category_name . "</td>";
        echo "<td><a href='" . base_url() . "/assets/details/" . $e_a_id . "' target='_blank' title='View'>" . $user_asset['a_asset_id'] . "</a></td>";
        echo "<td>" . $user_asset['model_name'] . "</td>";
        echo "<td>" . $user_asset['serial_no'] . "</td>";
        echo "<td>" . $ExpiryDate . "</td>";
        echo "<td>" . $wed . "</td>";
        // if($user_asset['status'] == ACTIVE){
        //     echo "<td>Active</td>";
        // }else{
        //     echo "<td>Inactive</td>";
        // }
        echo "<td nowrap>" . $convert_time . "</td>";
        echo "<td nowrap>";
        echo "<button class='btn btn-icon btn-sm btn-danger' title='Edit' onclick='revokeAssets(" . $user_asset['id'] . ")'><i class='ti ti-arrow-back-up'></i></button>";
        echo "</td>";
        echo "</tr>";
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