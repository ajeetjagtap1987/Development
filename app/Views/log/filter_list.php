
<?php

use App\Models\CommonModel;

$CommonModel = new CommonModel();

if (count($paginateData) > 0) {

    echo '<div class="table-responsive">';
    echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                <tr>
                                <th width='5%'>Id</th>

                                <th class='table_fixed_column_left_header'>Log</th>

                            </tr>
                                </thead>
                                <tbody class='refresh_table'>";


    $groupedData = [];


    foreach ($paginateData as $query) {
        $currentDate = date('d/m/Y', strtotime($query['created_at']));
        $groupedData[$currentDate][] = $query;
    }

    foreach ($groupedData as $date => $records) {

        echo "<tr>";
        echo "<td colspan='2'>";
        echo $date;
        echo "</td>";
        echo "</tr>";

        foreach ($records as $record) {

            echo "<tr>";
            echo "<td>";
            echo $record['id'];
            echo "</td>";
            echo "<td>";

            $jsonData = json_decode($record['log']);
            foreach ($jsonData as $key => $value) {

                if ($key == 'action_by') {
                    $data = $CommonModel->getSpecificDataByColumnName($table_name = 'user', $column_name = 'id', $value, $select = 'first_name,last_name');
                    $action_by = implode(', ', array_map(function ($item) {
                        return $item['first_name'] . ' ' . $item['last_name'];
                    }, $data));
                    $value = $action_by;
                }

                if ($key == 'action_on') {
                    $data = $CommonModel->getSpecificDataByColumnName($table_name = 'user', $column_name = 'id', $value, $select = 'first_name,last_name');
                    if (!empty($data)) {
                        $action_on = implode(', ', array_map(function ($item) {
                            return $item['first_name'] . ' ' . $item['last_name'];
                        }, $data));
                        $value = $action_on;
                    }
                }

                if ($key == 'action_date') {
                    $convert_time = $CommonModel->converToTz($value);
                    $value = $convert_time;
                }


                // echo "<b>" . $key . "</b>: " . $value . " , ";

                echo "
                                <table>
                                    <tr>
                                        <td> <b>"
                    . $key . " -
                                        </b></td>
                                    <td>
                                    " . $value .

                    "
                                    </td>
                                    </tr>

                                    </table>
                                ";
            }

            echo "</td>";
            echo "</tr>";
        }
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