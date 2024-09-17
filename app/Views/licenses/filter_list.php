<style>
    .quadrat {
        width: 50px;
        height: 50px;
        -webkit-animation: NAME-YOUR-ANIMATION 1s infinite;
        /* Safari 4+ */
        -moz-animation: NAME-YOUR-ANIMATION 1s infinite;
        /* Fx 5+ */
        -o-animation: NAME-YOUR-ANIMATION 1s infinite;
        /* Opera 12+ */
        animation: NAME-YOUR-ANIMATION 1s infinite;
        /* IE 10+, Fx 29+ */
        padding: 3px;
    }

    @-webkit-keyframes NAME-YOUR-ANIMATION {

        0%,
        49% {
            background-color: #ffcc00;
            color: black;
        }

        50%,
        100% {
            background-color: #e50000;
            color: white;
        }
    }
</style>
<?php

use App\Models\CommonModel;

$CommonModel = new CommonModel();




if (count($paginateData) > 0) {

    echo '<div class="table-responsive">';
    echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                    <tr>
                                          <th>Id</th>
                                          <th>License Name</th>


                                          <th>Product Key</th>

                                          <th>License To Email</th>
                                          <th>Assigned Count</th>
                                          <th>Assign To</th>

                                          <th width='5%'>User Limit</th>
                                          <th width='10%'>Expiry Date</th>

                                          <th width='9%'>Remaining Days</th>
                                          <th width='5%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";


    //     <th>Id</th>
    //     <th>Software Name</th>

    //   //   <th>Manufacturer</th>//
    //     <th>Product Key</th>
    //     <th>License To Name</th>
    //     <th>License To Email</th>


    //     <th>User Limit</th>
    //     <th>Expiry Date</th>
    //   //   <th width='15%'>Created Date</th>//
    //     <th>Remaining Days</th>
    //     <th width='5%'>Action</th>


    function datediff($enddate)
    {


        $createdDate1 = strtotime('now');


        $difference = round(($enddate - $createdDate1) / (60 * 60 * 24));

        return $difference;
    }

    foreach ($paginateData as $license) {
        $encrypter = \Config\Services::encrypter();
        $e_id = bin2hex($encrypter->encrypt($license['license_id']));
        $convert_time = $CommonModel->converToTz($license['created_date']);

        $assigned_user=$CommonModel->getUserLicenseByLicenseId($license['license_id']);


        $enddate = strtotime($license['expiry_date']);

        $dif = datediff($enddate);


        $manufacturer = $CommonModel->getDataById($table_name = 'manufacturer', $license['manufacturer_id']);
        $manufacturer_name = count($manufacturer) > 0 ? $manufacturer[0]['name'] : '';
        // $category =  $CommonModel->getDataById($table_name='category',$license['category_id']);
        // $category_name=count($category)>0 ? $category[0]['category_name'] : '';
        echo "<tr>";
        echo "<td>" . $license['license_id'] . "</td>";
        echo "<td><a href='" . base_url() . "/licenses/details/" . $e_id . "'  title='View' target='_blank'>" . $license['software'] . "</a></td>";
        // echo "<td>".$category_name."</td>";
        // echo "<td>" . $manufacturer_name . "</td>";
        if ($license['product_key']) {
            echo "<td>" . $license['product_key'] . "</td>";
        } else {
            echo "<td>" . "NA" . "</td>";
        }

        // echo "<td>" . $license['license_to_name'] . "</td>";
        echo "<td>" . $license['license_to_email'] . "</td>";
        echo "<td>" . count($assigned_user) . "</td>";
        echo "<td>" . $license['license_to_name'] . "</td>";
        echo "<td>" . $license['user_limit'] . "</td>";






        if ($license['expiry_date'] != '0000-00-00') {
            echo "<td>" . date(DATEFORMAT, strtotime($license['expiry_date'])) . "</td>";
        } else {
            echo "<td>" . ' NA ' . "</td>";
        }
        // if($license['status'] == ACTIVE){
        //     echo "<td>Active</td>";
        // }else{
        //     echo "<td>Inactive</td>";
        // }
        // echo "<td nowrap>" . $convert_time . "</td>";
        if ($license['expiry_date'] != '0000-00-00') {
            if ($dif <= 0) {
                echo "<td nowrap><span class='quadrat'>Expired</span></td>";
            } elseif ($dif <= 30 && $dif >= 0) {

                echo "<td nowrap><span class='quadrat'>$dif</span></td>";
            } else {
                echo "<td nowrap><span class=''>$dif</span></td>";
            }
        } else {
            echo "<td nowrap><span class=''>NA</span></td>";
        }

        echo "<td nowrap>";
        echo "<a href='" . base_url() . "/licenses/edit/" . $e_id . "' class='btn btn-icon btn-sm btn-primary' title='Edit' target='_blank'><i class='ti ti-edit'></i></a>";

         echo "<button class='btn btn-icon btn-sm btn-danger' title='Edit' onclick='deleteLicense(" . $license['license_id'] . ")'><i class='ti ti-trash'></i></button>";

        echo "</td>";
        echo "</tr>";
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