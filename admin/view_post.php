<?php 
  session_start();
  $con = mysqli_connect("localhost","root","","adminpanel");
  

   if(isset($_GET['id']))
  {

    $id = $_GET['id'];

    $select = "select * from `posts` where `id`=".$id;
    $res = mysqli_query($con, $select);
    $data= mysqli_fetch_assoc($res);
    $img_file = @$data['image'];


    $delete = "delete from `posts` where `id`=".$id;
    $res= mysqli_query($con,$delete);

      if($img_file != '') {
        $img_path= "image/latest_posts/".$img_file;
        if(file_exists($img_path)) {
          unlink($img_path);
        }
      }
  }

 $limit = 2;

  if(isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  else {
    $page = 1;
  }
  $start = ($page - 1) * $limit ;

  if(isset($_GET['search']))
  {
    $search = $_GET['search'];
    $sql_page = "select * from `posts` where titel like '%$search%'  limit $start , $limit";
    $total_rec = "select * from `posts` where titel like '%$search%' ";

  }
  else {
    $sql_page = "select * from `posts` limit $start , $limit";
    $total_rec = "select * from `posts`";

  }  

  $res = mysqli_query($con,$total_rec);
  $total_row = mysqli_num_rows($res);
  $total_page= ceil($total_row/$limit);
  $res_page = mysqli_query($con,$sql_page);

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
              <li class="breadcrumb-item active">letest post</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View post data</h3>
              </div>

               <div class=" ml-4 mt-2">
                <form method="get">
                  <label>Search titel :-</label>
                  <input type="text" name="search" placeholder="search titel">
                  <input type="submit"  name="submit" value="Search" class="btn btn-primary btn-sm">
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Titel</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Categori</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Delete</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
<?php 
                    while($data = mysqli_fetch_assoc($res_page)) 
                    {
?>
                    <tr>
                      <td><?php echo@$data['id'] ;?></td>
                      <td><img src="image/latest_posts/<?php echo @$data['image'];?>" width="100px"height="50px"> </td>
                      <td><?php echo@$data['titel'] ;?></td>
                      <td><?php echo@$data['name'] ;?></td>
                      <td><?php echo@$data['date'] ;?></td>
                      <td><?php echo@$data['categori'] ;?></td>
                      <td><?php echo@$data['description'] ;?></td>
                      
                      <td>
<?php 
                        if(@$data['status']==1) {
                          echo "<a href=active.php.?lid=".@$data['id']." class='btn btn-outline-success btn-sm'>Active</a>";
                        }
                        else { 
                          echo "<a href=deactive.php.?lid=".@$data['id']." class='btn btn-outline-danger btn-sm'>Deactive</a>";
                        }
?>
                      </td>
                      <td><a href="view_post.php?id=<?php echo @$data['id']; ?>">Delete</a> </td>
                      <td><a href="add_post.php?id=<?php echo @$data['id']; ?>">Update</a> </td>


                    </tr>
<?php 
                    }
?>
                  </tbody>                  
                </table>
                <div class="mt-3">
                   <label>Pages </label>
                  <a class="btn btn-primary btn-sm" href="view_post.php?page=1">All</a>    
<?php
                  if($page>1)
                  {
                        echo "<a href='view_post.php?page=".$page - 1 ."' class='btn btn-primary btn-sm' >pre</a>";

                  }
                  for ($i=1; $i<=$total_page; $i++)
                  {  
?>
                    <a class="btn btn-primary btn-sm" href="view_post.php?page=<?php echo $i; if(isset($_GET['search'])) {?> &search=<?php  echo $_GET['search']; } ?>"><?php echo $i; ?></a>    
<?php     
                  } 
                  if($page<=$total_page-1)
                  {
                        echo "<a href='view_post.php?page=".$page +1 ."' class='btn btn-primary btn-sm' >next</a>";

                  }  
?>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 
  include 'footer.php';
?>