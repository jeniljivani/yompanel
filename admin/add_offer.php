<?php 
  session_start();
  $con = mysqli_connect("localhost","root","","adminpanel");

    if(isset($_GET['id'])) {
      $id = $_GET['id'];
      $select = "select * from `offer` where `id`=".$id;
      $res = mysqli_query($con, $select);
      $data = mysqli_fetch_assoc($res);
      
    }

    if(isset($_POST['submit'])) {
    $user_id = $_SESSION['username']['id'];  
    $icon = $_POST['icon'];
    $titel = $_POST['titel'];
    $description = $_POST['description'];
    
    if(isset($_GET['id'])) {
      $update = "update `offer` set `icon`='$icon',`title`='$titel',`description`='$description' where `id`=".$_GET['id'];
      mysqli_query($con, $update);
      header("location:view_offer.php");      

    }
    else {

      $insert = "insert into `offer`(`user_id`,`icon`,`title`,`description`)values('$user_id','$icon','$titel','$description')";
      mysqli_query($con,$insert);
    }
    header("location:view_offer.php");
  }
  include 'header.php';
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>WHAT WE OFFER</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">WHAT WE OFFER</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<style type="text/css">    
    h6
    {
      color: red;
      display: none;
    }  
</style> 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
         
<style type="text/css">    
    h6
    {
      color: red;
      display: none;
    }  
</style>    <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add offer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputIcon1">Icon name</label>
                    <input type="text" name="icon"  value="<?php echo @$data['icon']; ?>" class="form-control" id="icon" placeholder="Enter icon">
                    <h6>enter your icon</h6>                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputTitel1">Titel</label>
                    <input type="text" name="titel"  value="<?php echo @$data['title']; ?>" class="form-control" id="title" placeholder="Enter titel">
                    <h6>enter your title</h6>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputDescription1">Description</label>
                    <input type="text" name="description"  value="<?php echo @$data['description']; ?>" class="form-control" id="description" placeholder="Description">
                    <h6>enter your description</h6>

                  </div>
                 <!--  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="image"  value="<?php echo @$data['image']; ?>" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div> -->
                  <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div> -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>            
          </div>      
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript" src="../../jquery-3.7.1.min.js"></script>

<script>
    
    $('#frm').submit(function(){
      var icon = $('#icon').val();
      if(icon == '') {
        $('#icon').siblings('h6').css('display','inline');
        return false;
      }
      var title = $('#title').val();
      if(title == ''){
        // alert("please enter name");
        $('#title').next('h6').css('display','inline');
        return false;
      }
      var description = $('#description').val();
      if(description == '') {
        $('#description').next('h6').css('display','inline'); 
        return false;
      }

    })

</script>
<?php 
  include 'footer.php';
?>