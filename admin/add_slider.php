<?php 
  session_start();
  $con = mysqli_connect("localhost","root","","adminpanel");

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $select = "select * from `slider` where `id`=".$id;
    $res = mysqli_query($con, $select);
    $data = mysqli_fetch_assoc($res);

  }


  if(isset($_POST['submit'])) 
  {
      $user_id = $_SESSION['username']['id'];
      $titel = $_POST['titel'];
      $description = $_POST['description'];
      $image = $_FILES['image']['name'];

      if($image=="") 
      {
        $imagename = @$data['image'];
      }
      else
      {
        $imagename = rand(1,10000).$image;
        $path = "image/slider/".$imagename;
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
      }
      if(isset($_GET['id'])) {
        $update = "update `slider` set `titel`='$titel',`description`='$description',`image`='$imagename' where `id`=".$_GET['id'];
        mysqli_query($con,$update);
        header("location:view_slider.php");      

      }
      else
      {
        $insert = "insert into `slider`(`user_id`,`titel`,`description`,`image`)values('$user_id','$titel','$description','$imagename')";
        mysqli_query($con,$insert);
      }
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
            <h1>Slider</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Slider</li>
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
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Slider</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Titel</label>
                    <input type="text" name="titel" value="<?php echo @$data['titel'] ?>"  class="form-control" id="title" placeholder="Enter titel">
                    <h6>enter your title</h6>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <input type="text" name="description" value="<?php echo @$data['description'] ?>" class="form-control" id="description" placeholder="Description">
                    <h6>enter your description</h6>                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <!-- <div class="custom-file"> -->
                        <input type="file" name="image" value="<?php echo @$data['image'] ?>"  class="custom-file-input" id="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        <h6>enter your image</h6>                        
                      <!-- </div> -->
                      <!-- <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div> -->
                    </div>
                  </div> 
                  <img style="width: 100px;" src="image/slider/<?php echo @$data['image']; ?>">
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
      var title = $('#title').val();
      if(title == ''){
        // alert("please enter name");
        $('#title').next('h6').css('display','inline');
        return false;
      }
      var description = $('#description').val();
      // var e_pat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/

      if(description == '') {
        $('#description').next('h6').css('display','inline'); 
        return false;
      }
      var img = $('#image').val();
      if(img == '') {
        $('#image').siblings('h6').css('display','inline');
        return false;
      }

    })

</script>
<?php 
  include 'footer.php';
?>