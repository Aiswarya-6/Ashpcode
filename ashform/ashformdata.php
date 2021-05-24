<?php
    
    global $wpdb;
    $table_name=$wpdb->prefix.'ashform';
    $result=$wpdb->get_results("select * from $table_name ORDER BY id ASC");

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <br>
  <br>
  <br>
  <h1>DATA FROM DATABASE</h1>
<table class="table table-bordered" id="ashTable" >
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Comments</th>
    <th></th>
  </tr>
  <?php
  
    foreach($result as $data)
  {
    ?>
  <tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->your_name;?></td>
    <td><?php echo $data->your_email;?></td>
    <td><?php echo $data->your_comments;?></td>

    <td><button id="element" class="btn btn-default show-modal" 
             onclick="edit_contact('<?php echo $data->id;?>')" >edit</button>
      
  </tr>
  <?php
}
?>
</table>


<div id="testmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Your details</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="" >
            <table class="table table-bordered" id="table">
              <tr>
                <th>Name  </th>
                <td><input type="text" name="your_name" id="name" value="<?php echo $data->your_name;?>"></td>
              </tr>
              <br>
              <tr>
                <th>Email id  </th>
                <td><input type="text" name="your_email" id="mail" value="<?php echo $data->your_email;?>">
                  <input type="hidden" name="id" id="id"></td>
              </tr>
              <br>
              <tr>
                <th>Cmments  </th>
                <td><input type="text" name="your_comments" id="comments" value="<?php echo $data->your_comments;?>"></td>
              </tr>
              <br>
              <div class="modal-footer">
               <tr colspan="2">
                <td colspan="2"><center><input type="submit" name="submit"  class="btn  btn-success"></center></td>
              </tr>
            </div>
            </table>
          </form>
            </div>
            
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
  
</script>

</html>