<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();


    }


    public function getData($table){
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->orderBy('id ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getSelectiveData($table, $coloumnname){
        $builder = $this->db->table($table);
        $builder->select($coloumnname);
        $builder->orderBy('id ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getSelectiveActiveData($table, $coloumnname){
        $builder = $this->db->table($table);
        $builder->select($coloumnname);
        $builder->orderBy('id ASC');
        $builder->where('deleted_by', NULL);
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getDataByColumnName($table,$coloumnname,$value)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($coloumnname, $value);
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getSpecificDataByColumnName($table,$coloumnname,$value,$select)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        $builder->where($coloumnname, $value);
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getSpecificDataActiveByColumnName($table,$coloumnname,$value,$select)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        $builder->where($coloumnname, $value);
        $builder->where('deleted_by', NULL);
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getAllData($table)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getAllActiveData($table)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where('status', ACTIVE);
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }


    public function getDataById($table,$id)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where('id', $id);
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }

    public function getAllDataByColumnName($table,$coloumnname,$value)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($coloumnname, $value);
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }



    public function getAllActiveDataByColumnName($table,$coloumnname,$value)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($coloumnname, $value);
        $builder->where('status', ACTIVE);
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }


    public function getFilesByReferIDAndType($reference_id, $type)
    {
        $builder =  $this->db->table('files');
        //$builder->whereIn('type',$rm, false);
        $builder->select('*');
        $builder->where('reference_id', $reference_id);
        $builder->where('type', $type);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function getFilesByReferIDAndFeedIDAndType($reference_id, $feed_id,$type)
    {
        $builder =  $this->db->table('files');
        //$builder->whereIn('type',$rm, false);
        $builder->select('*');
        $builder->where('reference_id', $reference_id);
        $builder->where('refer_feed_id', $feed_id);
        $builder->where('type', $type);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }




    public function deleteDataByColumnName($table,$coloumnname,$id)
    {
       $query = $this->db->query('delete from '.$table.' where '.$coloumnname.'="'.$id.'"');
        return TRUE;
    }

    public function insert_data($table,$data = array())
    {


        $this->db->table($table)->insert($data);


        return $this->db->insertID();
    }

    public function insert_data_batch($table,$data = array())
    {
        $this->db->table($table)->insertBatch($data);
        return $this->db->insertID();
    }


    public function update_data_batch($table, $data = array())
{
    foreach ($data as $item) {
        $id = $item['id'];
        unset($item['id']);

        $this->db->table($table)
            ->where('id', $id)
            ->update($item);
    }


    return $this->db->affectedRows() ;

}

    public function update_data($table,$id, $data = array())
    {

        $this->db->table($table)->update($data, array(
            "id" => $id,
        ));


        return $this->db->affectedRows() ;
    }

    public function updateDataByColumnName($table,$coloumnname,$id, $data = array())
    {
        $this->db->table($table)->update($data, array(
            $coloumnname => $id,
        ));
        return $this->db->affectedRows();
    }

    public function getAllDataByColumnNameExceptCurrent($table_name, $column_name, $value, $currentRecordId)
    {
        $query = $this->db->table($table_name)
            ->where($column_name, $value)
            ->where('id !=', $currentRecordId)
            ->get();

        return $query->getResultArray();
    }



    public function emailNotification($to,$email_message,$email_subject)
    {
        //---------email common setting -----------//
       $email = \Config\Services::email();

       $email->setFrom('noreply@digitalzonein.com', 'noreply@digitalzonein.com');
       $email->setTo(implode(', ', $to));
        //$email->setFrom('noreply@digitalzonein.com', 'noreply@digitalzonein.com');
        // $mail = new PHPMailer();
        // $mail->IsSMTP();
        // $mail->SMTPAuth   = true;
        // $mail->SMTPSecure = "tls";
        // $mail->Host       = "smtp.office365.com";
        // $mail->Port       = 587;
        // $mail->isHTML(true);
        // //$mail->SMTPKeepAlive = true;
        // $mail->CharSet = 'UTF-8';
        // $mail->SMTPDebug = 0;
        // //---------email common setting -----------//

        // $message_body = html_entity_decode('Hello,<br/><br/>'.$message_body.'<br/><br/>Thanks,', ENT_QUOTES, 'UTF-8');
        // $mail->Username   = 'noreply@digitalzonein.com';
        // $mail->Password   = '*)5nAn#*';
        // $mail->SetFrom('noreply@digitalzonein.com', 'noreply@digitalzonein.com');
        // $mail->AddReplyTo('noreply@digitalzonein.com', 'noreply@digitalzonein.com' );
        // $email->setSubject    = $subject;
        // $email->setMessage       = $email_message;
        // $email->setTo($data['u_email']);
       $email->setSubject($email_subject);
       $email->setMessage($email_message);
      // print_r($email);die;
        // if($email->Send())
        // {

        // }
        // else
        // {
        //    //$data = $email->printDebugger(['headers']);
        //    // print_r($data);
        // }
    }

    public function emailHeader(){
        $header='<html lang="en">

                <head>

                  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                  <meta name="viewport" content="initial-scale=1.0">
                  <meta name="format-detection" content="telephone=no">

                  <link rel="shortcut icon" href="'.base_url().'/public/assets/img/favicon.svg">
                  <title>
                    Digitalzone
                  </title>
                  <style type="text/css">

                  </style>

                </head>

                <body align="center" style="margin: 0;padding: 0;">

                  <table align="center" width="100%" style="background-color: #EFEFEF;border-spacing: 0;">
                    <tr>
                      <td style="padding: 20px;">
                        <table class="responsiveness" width="600" align="center"
                          style="margin: 0 auto;border-spacing: 0;border-collapse: collapse;padding :0;background-color: #ffffff; ">
                          <tr align="center">
                            <td align="center" style="margin: 0;padding: 10px 0px 20px 0px;">
                              <img src="'.base_url().'/public/assets/img/digitalzone_logo.png" alt="Logo"
                                width="110"><br>
                            </td>
                          </tr>';
                          return $header;
    }
    public function emailFooter(){
        $footer='<tr><td style="padding:10px">
                <br>
                Thank You,<br>
                Digitalzone Team.</td>
             </tr><tr bgcolor="#1D2E48" height="6"><td>
                </td>
             </tr>
             </table></td></tr>
              </table>
            </body>
            </html>';
             return $footer;
    }
    public function emailNotificationWithAttachment($to,$email_message,$email_subject,$attchment)
    {
        //print_r($this->emailHeader().$email_message.$this->emailFooter());die;

        //---------email common setting -----------//
       $email = \Config\Services::email();

       $email->setFrom('noreply@digitalzonein.com', 'noreply@digitalzonein.com');
      // $email->setTo(implode(', ', array_merge($to,array('api@digitalzonein.com'))));
        $email->setTo(implode(', ', array_merge($to,array('cnarkhede@digitalzonein.com'))));
       //$email->setTo(implode(', ', $to));
        //$email->setFrom('noreply@digitalzonein.com', 'noreply@digitalzonein.com');
        // $mail = new PHPMailer();
        // $mail->IsSMTP();
        // $mail->SMTPAuth   = true;
        // $mail->SMTPSecure = "tls";
        // $mail->Host       = "smtp.office365.com";
        // $mail->Port       = 587;
        // $mail->isHTML(true);
        // //$mail->SMTPKeepAlive = true;
        // $mail->CharSet = 'UTF-8';
        // $mail->SMTPDebug = 0;
        // //---------email common setting -----------//

        // $message_body = html_entity_decode('Hello,<br/><br/>'.$message_body.'<br/><br/>Thanks,', ENT_QUOTES, 'UTF-8');
        // $mail->Username   = 'noreply@digitalzonein.com';
        // $mail->Password   = '*)5nAn#*';
        // $mail->SetFrom('noreply@digitalzonein.com', 'noreply@digitalzonein.com');
        // $mail->AddReplyTo('noreply@digitalzonein.com', 'noreply@digitalzonein.com' );
        // $email->setSubject    = $subject;
        // $email->setMessage       = $email_message;
        // $email->setTo($data['u_email']);
       $email->setSubject($email_subject);
       $email->setMessage($this->emailHeader().$email_message.$this->emailFooter());
       if(count($attchment)>0){
           foreach($attchment as $att){
            $email->attach($att);
           }
       }

        if($email->Send())
        {

        }
        // else
        // {
        //    //$data = $email->printDebugger(['headers']);
        //    // print_r($data);
        // }

    }



    public function converToTz($time)
    {
        // timezone by php friendly values
        $fromTz=date_default_timezone_get();
        $toTz=session('user_timezone');
        $date = new \DateTime($time, new \DateTimeZone($fromTz));
        $date->setTimezone(new \DateTimeZone($toTz));
        $time= $date->format(DATETIMEFORMAT);
        return $time;
    }

    public function getUserAssetsByAssetId($asset_id)
    {
        $builder =  $this->db->table('user_assets');
        $builder->select('*');
        $builder->where('asset_id', $asset_id);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function checkUserAssetsAssigned($user_id,$asset_id)
    {
        $builder =  $this->db->table('user_assets');
        $builder->select('*');
        $builder->where('user_id', $user_id);
        $builder->where('asset_id', $asset_id);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function getUserLicenseByLicenseId($license_id)
    {
        $builder =  $this->db->table('user_licenses');
        $builder->select('*');
        $builder->where('license_id', $license_id);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function checkUserLicenseAssigned($user_id,$license_id)
    {
        $builder =  $this->db->table('user_licenses');
        $builder->select('*');
        $builder->where('user_id', $user_id);
        $builder->where('license_id', $license_id);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function checkUserApplicationsAssigned($user_id,$application_id)
    {
        $builder =  $this->db->table('user_applications');
        $builder->select('*');
        $builder->where('user_id', $user_id);
        $builder->where('application_id', $application_id);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function getUserApplicationByAppId($applications_id)
    {
        $builder =  $this->db->table('user_applications');
        $builder->select('*');
        $builder->where('application_id', $applications_id);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }

    public function checkVendorInvoiceByVendor($vendor_id,$invoice_no)
    {
        $builder =  $this->db->table('vendor_invoice');
        $builder->select('*');
        $builder->where('vendor_id', $vendor_id);
        $builder->where('invoice_no', $invoice_no);
        $builder->orderBy('created_date ASC');
        $query    = $builder->get();
        return $query->getResultArray();
    }


    public function checkCsvUtf($data)
    {
        $checkutf=mb_detect_encoding($data[0], ['ASCII', 'UTF-8'], false);
        if($checkutf == 'UTF-8'){
            return FALSE;
        }else{
            return TRUE;
        }
        die;
    }
    public function parseCsv($filepath)
    {
        if(!file_exists($filepath))
        {
            return FALSE;
        }
        $fp = fopen($filepath, 'r');
        $csvArray = array();
        //$flag = true;
        $header = fgetcsv($fp);
        $header_cleans=preg_replace("/[^(\x20-\x7F)]*/", "",$header);
        $header_clean=str_replace('"', '', $header_cleans);
       // print_r($header);
        while (($row = fgetcsv($fp, 0, ',', '"', '"')) !== FALSE)
        {
            //$row = array_map("utf8_encode", $row);
            //if($flag) { $flag = false; continue; }
            //$csvArray[] =$row;
           // print_r($row);
            array_map('trim', $row);
            if(!empty($row) && array_filter($row)){
                $csvArray[] = @array_combine($header_clean, $row);
            }
        }
        fclose($fp);
        return  $csvArray;
    }
    public function parseCsvCheckUtf($filepath)
    {
        if(!file_exists($filepath))
        {
            return FALSE;
        }
        $fp = fopen($filepath, 'r');
        $csvArray = array();
        //$flag = true;
        $header = fgetcsv($fp);
       // print_r($header);
        $csvArray[] = $header;
        fclose($fp);
        return  $csvArray;
    }

    public  function logCreate($action,$details){

        $data = array(
            'action' =>$action ,
            'action_details' => $details,
            'action_by' =>  session('user_id'),
            'action_date' => date('Y-m-d H:i:s')
        );

        $jsonData = json_encode($data);

        $this->db->table('log_master')->insert([
            'log' => $jsonData
        ]);

        return $this->db->insertID();

    }
}

