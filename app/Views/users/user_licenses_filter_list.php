<style>
.quadrat {
  width: 50px;
  height: 50px;
  -webkit-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Safari 4+ */
  -moz-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Fx 5+ */
  -o-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Opera 12+ */
  animation: NAME-YOUR-ANIMATION 1s infinite;  /* IE 10+, Fx 29+ */
  padding: 3px;
}

@-webkit-keyframes NAME-YOUR-ANIMATION {
  0%, 49% {
    background-color: 	#ffcc00;
    color: black;
  }
  50%, 100% {
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
                                          <th width='5%'>Sr No.</th>
                                          <th>license Name</th>
                                          <th>Key</th>
                                          <th width='10%'>Remaining Days</th>
                                          <th width='10%'>Created Date</th>
                                          <th width='3%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
    $i = 0;


    function datediff($enddate)
    {


        $createdDate1 = strtotime('now');


        $difference = round(($enddate - $createdDate1) / (60 * 60 * 24));

        return $difference;
    }

    foreach ($paginateData as $user_licenses) {
        $encrypter = \Config\Services::encrypter();
        $e_id = bin2hex($encrypter->encrypt($user_licenses['ul_id']));
        $convert_time = $CommonModel->converToTz($user_licenses['created_date']);
        $category =  $CommonModel->getDataById($table_name = 'category', $user_licenses['category_id']);
        $category_name = count($category) > 0 ? $category[0]['category_name'] : '';


        $i++;

        $enddate = strtotime($user_licenses['expiry_date']);

        $dif =  datediff($enddate);
        echo "<tr>";
        echo "<td>" . $i . "</td>";

        echo "<td>" . $user_licenses['name'] . "</td>";
        if ($user_licenses['product_key']) {
            echo "<td>" . $user_licenses['product_key'] . "</td>";
        } else {
            echo "<td>" . "NA" . "</td>";
        }




        if ($user_licenses['expiry_date'] != '0000-00-00') {
            if ($dif <= 0) {
                echo "<td nowrap ><span class='quadrat'>Expired</span></td>";
            } elseif ($dif <= 30 && $dif >= 0) {

                echo "<td nowrap><span class='quadrat'>$dif</span></td>";
            } else {
                echo "<td nowrap><span class=''>$dif</span></td>";
            }
        } else {
            echo "<td nowrap><span class=''>NA</span></td>";
        }



        // if($user_licenses['status'] == ACTIVE){
        //     echo "<td>Active</td>";
        // }else{
        //     echo "<td>Inactive</td>";
        // }
        echo "<td nowrap>" . $convert_time . "</td>";
        echo "<td nowrap>";
        echo "<button class='btn btn-icon btn-sm btn-danger' title='Edit' onclick='revokeLicense(" . $user_licenses['ul_id'] . ")'><i class='ti ti-arrow-back-up'></i></button>";
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