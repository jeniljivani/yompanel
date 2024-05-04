<?php 
  session_start();
  $con = mysqli_connect("localhost","root","","adminpanel");

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $select = "select * from `posts` where `id`=".$id;
    $res = mysqli_query($con, $select);
    $data = mysqli_fetch_assoc($res);

  }
  $category_select= "select * from `category`";
  $category_res = mysqli_query($con, $category_select);

  if(isset($_POST['submit'])) 
  {
    $user_id = $_SESSION['username']['id'];
    $name = $_SESSION['username']['name'];
    $imagename = $_FILES['image']['name'];
    if($imagename=="") 
    {
      $image = $data['image'];
    }
    else
    {
      $image = rand(1,10000).$imagename;
      $path = "image/latest_posts/".$image;
      move_uploaded_file($_FILES['image']['tmp_name'], $path);
    }
    $titel = $_POST['titel'];
    // $name = $_POST['name'];
    $date = $_POST['date'];
    $categori = $_POST['categori'];
    $description = $_POST['description'];

    if(isset($_GET['id'])) {
      $update = "update `posts` set `image`='$image',`titel`='$titel',`name`='$name',`date`='$date',`categori`='$categori',`description`='$description' where `id`=".$_GET['id'];
      mysqli_query($con,$update);
      header("location:view_post.php");
    }
    else
    {
      $insert = "insert into `posts`(`user_id`,`image`,`titel`,`name`,`date`,`categori`,`description`)values('$user_id','$image','$titel','$name','$date','$categori','$description')";
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
            <h1>Letest post</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Letest post</li>
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
                <h3 class="card-title">Add post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <input type="file" name="image" value="<?php echo @$data['image'] ?>"  class="custom-file-input" id="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        <h6>enter your image</h6>                        
                    </div>
                      <img style="width: 100px" src="image/latest_posts/<?php echo @$data['image']; ?>">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Titel</label>
                    <input type="text" name="titel" value="<?php echo @$data['titel'] ?>"  class="form-control" id="title" placeholder="Enter titel">
                    <h6>enter your title</h6>                        

                  </div>
                  <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name"  value="<?php echo @$data['name']; ?>" class="form-control" id="exampleInputName1" placeholder="Enter name">
                  </div> -->
                  <div class="form-group">
                    <label for="exampleInputDate1">Date</label>
                    <input type="date" name="date"  value="<?php echo @$data['date']; ?>" class="form-control" id="date" placeholder="Enter date">
                    <h6>enter your date</h6>                        

                  </div>
                  <div class="form-group">
                    <label for="exampleInputcategori1">Category</label>
                    <select name="categori" class="form-control" id="category" >
                      <option selected disabled hidden value="">SELECT CATEGORY</option>
<?php 
                        while($cat_data = mysqli_fetch_assoc($category_res)) 
                        {
?>                                            
                        <option  value="<?php echo @$cat_data['category']; ?>" <?php if(@$data['categori']==@$cat_data['category']) { ?> selected <?php } ?>><?php echo @$cat_data['category']; ?></option>
<?php 
                        }
?>                                            
                    </select>
                        <h6>enter your category</h6>                        

                  </div>
                  <div class="form-group">
                    <label for="exampleInputDescription1">Description</label>
                    <input type="text" name="description" value="<?php echo @$data['description'] ?>" class="form-control" id="description" placeholder="Description">
                    <h6>enter your description</h6>  

                  </div>
                  
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
      var img = $('#image').val();
      if(img == '') {
        $('#image').siblings('h6').css('display','inline');
        return false;
      }
      var title = $('#title').val();
      if(title == ''){
        // alert("please enter name");
        $('#title').next('h6').css('display','inline');
        return false;
      }
       var date = $('#date').val();
      if(date == ''){
        // alert("please enter name");
        $('#date').next('h6').css('display','inline');
        return false;
      }
      var category = $('#category').val();
    
      if(category == null){
        $('#category').siblings('h6').css('display','inline');
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