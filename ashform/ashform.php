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

function ashdisplay()
{
    include_once("ashformdata.php");
}
function ash_admin_menu()
{
add_menu_page('forms','AshForms','manage_options','ash_admin_menu','ash_admin_menu_main','dashicons-book',6);
  add_submenu_page('ash_admin_menu','ashform','Data',
  'manage_options','ash_admin_menu_sub_archive','ash_admin_menu_sub_archive');
}

add_action('admin_menu','ash_admin_menu');

function ash_admin_menu_main()
{
   
}
add_shortcode('data','ash_admin_menu_main');

function ash_admin_menu_sub_archive()
{
   include_once("ashformdata.php");
   echo '<h2><a href="http://localhost/wordpress/uontact-us/">CONTACT US</a></h2><br>';
}
function ashform_footer_action_javascript()
 { 
  ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>

function edit_contact($id)

{
$(document).ready(function(){

  $('#element').on('click',(function(){

    $('#testmodal').modal('show')
  });
    });

ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';

var id = id;
      $.ajax({
      type : "post",
      action: 'ashform_update',
      data:{id: id}
      
    };
      jQuery.post(ajaxurl, data, function(response) {
        responseData = jQuery.parseJSON( response );
        if(responseData)
        {
          jQuery('#id').val(responseData.id);
          jQuery('#name').val(responseData.your_name);
          jQuery('#mail').val(responseData.your_email);
          jQuery('#comments').val(responseData.your_comments);
          
        }
        success: function(show)
      {
        $("#testmodal").modal('show');
      }
      });
</script>
add_action( 'wp_footer', 'ashform_footer_action_javascript' );
<?php
}
add_action("wp_ajax_ashform_update" , "ashform_update");
add_action("wp_ajax_nopriv_ashform_update" , "ashform_update");

function ashform_update()
{
  global $wpdb;
  $id = $_POST['id'];
  $query = "SELECT * FROM ".$wpdb->prefix."ashform"." WHERE `id` = $id";
  $fieldDetails = $wpdb->get_row( $query );
  echo json_encode($fieldDetails);
  wp_die();
}
?>


