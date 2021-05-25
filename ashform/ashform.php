<?php
/*
Plugin Name: ashform
Plugin URI: 
Description: This is my first attempt
Version: 1.0
Author: Aiswarya
Author URI: 
Copyright: © 2021 Aiswarya. All rights reserved.
*/
function ashCreateTable()
{
  global $wpdb;

  if($wpdb->get_var("show tables like `$wpdb->prefix"."ashform`") != "$wpdb->prefix"."ashform")
  {
    $sql =   "CREATE TABLE $wpdb->prefix"."ashform
               (`id` int(11) NOT NULL AUTO_INCREMENT,
               `your_name` varchar(256) NOT NULL,
               `your_email` varchar(256) NOT NULL,
               `your_comments` varchar(500) NOT NULL,
                PRIMARY KEY id (id) );";

               require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
               dbDelta($sql);         
  }
}
register_activation_hook( __FILE__, 'ashCreateTable' );

function form_plugin()
{
    $content='';
    $content.='<form method="post" action="http://localhost/wordpress/thank-you/">';
    $content.='<br> <labelfor="Your_name">Your Name</label>';
    $content.='<br> <input type="text" name="your_name" class="form control" placeholder="enter your name"/>'; 
    $content.=' <br> <label for="your email">Your EmailID</label>';
    $content.=' <br><input type="email" name="your_email" placeholder="enter your email"/>';
    $content.=' <br><label> Your Comments</labels>';
    $content.=' <br><textarea name="your_comments" placeholder="enter your comments" class="form control"></textarea>';
    $content.=' <br><input type="submit" name="form_plugin_submit" class="btn btn-md btn primary" value="submit"/>';
 
  return $content;

}
add_shortcode('form','form_plugin');


function form_capture()
{
           if(isset($_POST['form_plugin_submit']))
           {
           global  $wpdb;
            $your_name=$_POST['your_name'];
            $your_email=$_POST['your_email'];
            $your_comments=$_POST['your_comments'];
           $data=array( 
                        'your_name'=>$your_name,
                        'your_email'=>$your_email,
                        'your_comments'=>$your_comments);

          $table_name=$wpdb->prefix.'ashform';

          $wpdb->query("insert into $table_name(your_name,your_email,your_comments)
                                values('$your_name','$your_email','$your_comments')");

       }
}
add_action('wp_head','form_capture');

function ash_admin_menu()
{
 add_menu_page('forms','AshForms','manage_options','ash_admin_menu','ash_admin_menu_main','dashicons-book',6);
  add_submenu_page('ash_admin_menu','ashform','Archive',
  'manage_options','ash_admin_menu_sub_archive',);
}

add_action('admin_menu','ash_admin_menu');
function ash_admin_menu_main()
{
  include(plugin_dir_path(__FILE__).'ashformdata.php');
  add_action( 'admin_footer', 'ashform_footer_action_javascript' );
}
function ashform_footer_action_javascript() { ?>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <script type="text/javascript" >

 function edit_contact(id)
 {   
  ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
  
  var data = { type : "post", 'action': 'ashform_update','id': id };
 
        jQuery.post(ajaxurl, data, function(response) {
        responseData = jQuery.parseJSON( response );
        if(responseData)
        {
          jQuery('#id').val(responseData.id);
          jQuery('#name').val(responseData.your_name);
          jQuery('#mail').val(responseData.your_email);
          jQuery('#comments').val(responseData.your_comments);
          
          $("#testmodal").modal('show');
        }
      });
        
     } 
        
        
  </script>
  <?php
  }
  
  add_action("wp_ajax_ashform_update" , "ashform_update");
  add_action("wp_ajax_nopriv_ashform_update" , "ashform_update");
  
  function ashform_update()
  {
    global $wpdb;

    $table_name=$wpdb->prefix.'ashform';
    $id = $_POST['id'];
    $query = "SELECT * FROM ".$wpdb->prefix."ashform"." WHERE `id` = $id";
    $data = $wpdb->get_row( $query );
      
            $your_name=$_POST['your_name'];
            $your_mail=$_POST['your_email'];
            $your_comments=$_POST['your_comments'];

            if (isset($_POST['edit'])) 
            {

            $wpdb->update($table_name,
                  array(
                        'your_name'=>$your_name,
                        'your_email'=>$your_mail,
                        'your_comments'=>$your_comments),
                  array(
                         'id'=>$id
                       )
                  );
                
            } 
   
    echo json_encode($data);
    wp_die();
  }
 
?>


