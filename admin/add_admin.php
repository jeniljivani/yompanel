<?php 
  session_start();
  $con = mysqli_connect("localhost","root","","adminpanel");

    if(isset($_GET['id'])) {
      $id = $_GET['id'];
      $select = "select * from `login` where `id`=".$id;
      $res = mysqli_query($con, $select);
      $data = mysqli_fetch_assoc($res);
      
    }

    if(isset($_POST['submit'])) {
    $user_id = $_SESSION['username']['id'];  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = $_FILES['image']['name'];

      if($image=="") 
      {
        $imagename = $data['image'];
      }
      else
      {
        $imagename = rand(1,10000).$image;
        $path = "image/admin/".$imagename;
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
      }


    $select ="select * from `login` where `email`='$email'";
    $select_res = mysqli_query($con, $select);
    $rec = mysqli_num_rows($select_res);
    


    if(isset($_GET['id'])) {
      $update = "update `login` set `name`='$name',`email`='$email',`password`='$password',`image`='$imagename' where `id`=".$_GET['id'];
      mysqli_query($con, $update);
      header("location:view_admin.php");      
    }
    else {
      if($rec==0) {
        $insert = "insert into `login`(`name`,`email`,`password`,`image`)values('$name','$email','$password','$imagename')";
        mysqli_query($con,$insert);
      }
      else {
        $error = "this is alrady exist..!";
      }
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
            <h1>Admin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Admin</li>
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
                <h3 class="card-title">Add Admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Admin name</label>
                    <input type="text" name="name"  value="<?php echo @$data['name']; ?>" class="form-control" id="name" placeholder="Enter name">
                    <h6>enter your name</h6>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email"  value="<?php echo @$data['email']; ?>" class="form-control" id="email" placeholder="Enter email">
                    <h6>enter your email</h6>
                    <h6 style="color: red"><?php echo @$error; ?></h6>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password"  value="<?php echo @$data['password']; ?>" class="form-control" id="password" placeholder="Password">
                    <h6>enter your password</h6>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <input type="file" name="image" value="<?php echo @$data['image']; ?>" class="custom-file-input" id="img">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        <h6>enter your image</h6>                      
                    </div>
                    
                    <img style="width: 100px" id="fimg"> src="image/admin/<?php echo @$data['image']; ?>">
                  </div>                 
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit"  class="btn btn-primary">Submit</button>
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
      var name = $('#name').val();
      if(name == ''){
        // alert("please enter name");
        $('#name').next('h6').css('display','inline');
        return false;
      }
      var email = $('#email').val();
      var e_pat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
      if(e_pat.test(email)==false) {

        $('#email').next('h6').css('display','inline'); 
        return false;
      }
      var pass = $('#password').val();
      // var p_pat = /^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,12}/

      if(pass == '') {
        $('#password').next('h6').css('display','inline');
        return false;
      }

      var img = $('#image').val();
      // var im = $('#fimg').attr('src');
      // $('#image')

      if(img == '') {
        $('#image').siblings('h6').css('display','inline');
        return false;
      }

    })

</script>


<?php 
  include 'footer.php';
?>
