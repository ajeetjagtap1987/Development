
<?php 
use App\Models\CommonModel;
$CommonModel = new CommonModel();

        if(count( $paginateData ) > 0 ) {
            echo '<div class="table-responsive">';
            echo "<table id='zero_config' class='table table-striped '>
                                <thead>
                                    <tr>
                                          <th>Id</th>
                                          <th>Vendor Name</th>
                                          <th>Invoice No.</th>
                                          <th>Invoice Date</th>
                                          <th>Total Items Count</th>
                                          <th>Total Amount</th>
                                          <th width='20%'>Created Date</th>
                                          <th width='5%'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class='refresh_table'>";
            foreach( $paginateData as $vendor_invoice ){
                $encrypter = \Config\Services::encrypter();
                $e_id=bin2hex($encrypter->encrypt($vendor_invoice['id']));
                $convert_time = $CommonModel->converToTz($vendor_invoice['created_date']);
                $vendor =  $CommonModel->getDataById($table_name='vendor',$vendor_invoice['vendor_id']);
                $vendor_name=count($vendor)>0 ? $vendor[0]['supplier_name'] : '';
                $vendor_invoice_copy =  $CommonModel->getFilesByReferIDAndType($vendor_invoice['id'],VENDOR_INVOICE);
                echo "<tr>";
                echo "<td>".$vendor_invoice['id']."</td>";
                echo "<td>".$vendor_name."</td>";
                echo "<td>".$vendor_invoice['invoice_no']."</td>";

              

                if($vendor_invoice['invoice_date']){
                    echo "<td>" .  date( DATEFORMAT, strtotime($vendor_invoice['invoice_date'])). "</td>";
                    }


                echo "<td>".$vendor_invoice['total_items_count']."</td>";
                echo "<td>".$vendor_invoice['currency'].' '.$vendor_invoice['total_amount']."</td>";
                echo "<td nowrap>".$convert_time."</td>";
                echo "<td nowrap>";
                echo "<a href='".base_url()."/vendor_invoice/edit/".$e_id."' class='btn btn-icon btn-sm btn-primary' title='Edit'><i class='ti ti-edit'></i></a>";
                if(count($vendor_invoice_copy)>0){
                     echo '<a class="btn btn-icon btn-sm btn-success" target="_blank" title="Download" href="'.base_url()."/".PUBLIC_PATH.$vendor_invoice_copy[0]['file_url'].'" download><i class="ti ti-download"></i></a>';
                }
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