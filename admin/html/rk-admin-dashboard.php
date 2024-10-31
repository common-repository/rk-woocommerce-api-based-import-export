<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * WC_Admin class.
 */
require_once RK_PLUGIN_ROOT_DIR.'includes/wcApi.php';
class RK_page_contents extends wcApi  {
    /**
     * Constructor.
     */
    
    public function __construct() {
        parent::__construct();
        $action_method='';
        $action_method = (isset($_REQUEST['action_method'])) ? $_REQUEST['action_method'] : 'output';
        $this->$action_method();
        
       
    }    
    
    function csv_to_array($filename='', $delimiter=','){
        if(!file_exists($filename) || !is_readable($filename)){
             die("Error: csv file not found.");
        }

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    } 
    
        
    
       public function import_csv_data($import_type='products') {
           $import_type = (empty($_REQUEST['import_type']))?$import_type:$_REQUEST['import_type']; 
        header( 'Content-type: text/html; charset=utf-8' );
           $fullsize_path =   get_attached_file( $_REQUEST['file_id'] );
           
           if(file_exists($fullsize_path)){               
                         $fileData=$this->csv_to_array($fullsize_path,",");                        
                         $noOfLines = count($fileData);        

                         if ($noOfLines > 0) {
                             $html='';
                            foreach($fileData as $key=>$val){
                               
                                
                                $response =  $this->importItems($val,$import_type);
                                
                              
                                
                                $html .=  "<div class='alert alert-success' role='alert'>".$val['sku'].':'.$response->{'body'}."</div>";
                                
                                
                                
                            }
                            
                             $this->getHtml($html );
                         }else {
                             die("error: records not found");
                         }
           }else{
               die("Error: csv file not found.");
           }
         
           //print_r($_REQUEST);
       } 
    
    
    public function output() {
        ?>

        <div class="wrap rk_plugin">
            <div class="bs-example">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#sectionA"><h2>WooCommerce Import Export </h2></a></li>
                    <!--li><a data-toggle="tab" href="#sectionB">Section B</a></li-->

                </ul>
                <div class="tab-content">

                    <div id="sectionA" class="tab-pane fade in active">


                        <div class="divider"></div>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                           Settings
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                        <a href="https://docs.woothemes.com/document/woocommerce-rest-api/" target="_blank">How to Get WooCommerce REST API details?</a>
                                        <!-- contains goes here -->
                                        <?php $this->apiDetailsFrm();?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                            Product Import
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="info file_info"></div>
<div class="container-fluid">
    <div>
        <ul class="list-group">
            <li class="list-group-item"><h4>Download import csv sheet Samples</h4></li>
            <li class="list-group-item"><a href="<?php  echo plugins_url('/'.RK_PLUGIN_NAME.'/files/wc_simple_products_csv_samples.csv'); ?>">Products</a></li>
            <li class="list-group-item"><a href="<?php  echo plugins_url('/'.RK_PLUGIN_NAME.'/files/rk_wc_orders.csv'); ?>">Orders</a></li>
             <li class="list-group-item"><a href="<?php  echo plugins_url('/'.RK_PLUGIN_NAME.'/files/rk_wc_customers.csv'); ?>">Customers</a></li>           
           
        </ul>      
  
        
    </div>
<form action="" name="import_frm" id="import_frm" method="post" enctype="multipart/form-data">
<?php

//upload form
$this->do_action_upload_form();
?>   
<input type='hidden' name='action_method' value='import_csv_data'>

<input type='submit' class="rk_import_btn btn btn-info btn-lg " style="background-color: #000000;" value='IMPORT'>

</form>
</div>



                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                            Export
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
 <div class="list-group">
  <a href="<?php echo admin_url('admin.php') . "?page=rk-admin-dashboard&action_method=export&export_type=products"; ?>" class="list-group-item ">
    <h4 class="list-group-item-heading">Export Products</h4>
    <p class="list-group-item-text">-> In CSV formate click here</p>
  </a>
  
     
     
    <a href="<?php echo admin_url('admin.php') . "?page=rk-admin-dashboard&action_method=export&export_type=orders"; ?>" class="list-group-item ">
    <h4 class="list-group-item-heading">Export Orders</h4>
    <p class="list-group-item-text">-> In CSV formate click here</p>
  </a>   
     
  
  
          <a href="<?php echo admin_url('admin.php') . "?page=rk-admin-dashboard&action_method=export&export_type=reports"; ?>" class="list-group-item ">
    <h4 class="list-group-item-heading">Export Reports</h4>
    <p class="list-group-item-text">-> In CSV formate click here</p>
  </a>  
     
          <a href="<?php echo admin_url('admin.php') . "?page=rk-admin-dashboard&action_method=export&export_type=customers"; ?>" class="list-group-item ">
    <h4 class="list-group-item-heading">Export Customers</h4>
    <p class="list-group-item-text">-> In CSV formate click here</p>
  </a> 
     
   <a href="<?php echo admin_url('admin.php') . "?page=rk-admin-dashboard&action_method=export&export_type=coupons"; ?>" class="list-group-item ">
    <h4 class="list-group-item-heading">Export Coupons</h4>
    <p class="list-group-item-text">-> In CSV formate click here</p>
  </a>
              
</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
            </div>

        <?php
    }
    function do_action_upload_form() {

        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        } else {
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }
        ?>




            <!--i class="fa fa-file-excel-o fa-6"></i -->
            
                <h3 class="h3"><label>SELECT FILE TO IMPORT</label></h3>
                <input class="header_logo_url input-lg" type="text" name="header_logo" size="60" value="">
                <select name="import_type" class="selectpicker input-lg" data-live-search="true">
                    <option data-tokens="products" value="products">Products</option>
  <option data-tokens="orders" value="orders">Orders</option>
  <option data-tokens="customers" value="customers">Customers</option>
  

</select>
              
                
                <br><br>
                <a href="#" class="rk_upload_file btn btn-info btn-lg" role="button">CHOOSE FILE</a>

               

         



            <script type="text/javascript">
                var ajaxurl = "<?php echo admin_url('admin-ajax.php') . "?page=rk-admin-dashboard&rk_action=upload"; ?>";
            </script>

        <?php
    }
    
    
   
    function apiDetailsFrm(){
        
$option_name = 'rk_setting_values' ;

$sav_details =  (isset($_REQUEST['sav_details']))?$_REQUEST['sav_details']:'';
$data['api_site_url'] = (isset($_REQUEST['api_site_url']))?$_REQUEST['api_site_url']:'';
$data['api_key'] = (isset($_REQUEST['api_key']))?$_REQUEST['api_key']:'';
$data['api_secrate'] =  (isset($_REQUEST['api_secrate']))?$_REQUEST['api_secrate']:'';

$new_value = serialize($data);

if ( !empty($sav_details ) ) {
    if ( get_option( $option_name ) !== false ) {

        // The option already exists, so we just update it.
        update_option( $option_name, $new_value );

    } else {

        // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        add_option( $option_name, $new_value, $deprecated, $autoload );
    }
}
$details = unserialize(get_option( $option_name ));

        ?>
            <div>
                <form action="" name="import_frm" method="post" enctype="multipart/form-data">
                    <h4>Site Url:</h4> <input placeholder="http://www.ravikatre.in" class=" input-lg" type="text" name="api_site_url" size="60" value="<?php echo $details['api_site_url'] ?>">
                <h4>Consumer Key:</h4> <input placeholder="Ex: ck_88f2d7dc424150bffc6cd8dbf50bb6bc45275aea" class=" input-lg" type="text" name="api_key" size="60" value="<?php echo $details['api_key'] ?>">
                <h4>Consumer Secret:</h4> <input placeholder="Ex: cs_68ff43ad77f9cab17df48739ccdff207afcc9e92" class="input-lg" type="text" name="api_secrate" size="60" value="<?php echo $details['api_secrate'] ?>"><br><br>
               

                <input type='submit' class="rk_import_btn btn btn-info btn-lg " style="background-color: #000000;" value='Save' name="sav_details">
                </form>
            </div>    
        <?php
    }
    
  
    
    function export($export_type='products'){
       
        $export_type = (empty($_REQUEST['export_type']))?$export_type:$_REQUEST['export_type'];
       
        $result =  (array) $this->getItems($export_type);
        
        $headers = array_keys($result[$export_type][0]);        
        $this->export_csv($headers,$result[$export_type],'rk_wc_'.$export_type.'.csv');
       
        //print_r($result);
        exit;
    }
    
    
    function getHtml($contents){
        
        ?>
            <div class="wrap rk_plugin">
            <div class="bs-example">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#sectionA"><h2>WooCommerce Import Export </h2></a></li>
                    <!--li><a data-toggle="tab" href="#sectionB">Section B</a></li-->

                </ul>
                 <div class="tab-content">

                    <div id="sectionA" class="tab-pane fade in active">


                        <div class="divider"></div>
                        <input action="action" type="button" class="btn btn-success btn-lg" value="Back" onclick="history.go(-1);" >
                         <div class="divider"></div>
                <?php echo $contents; ?>
                        </div>
                     </div>
                </div>
                 </div>
            </div>
            <?php
    }
    
}
new RK_page_contents();
?>

