
<?php
   session_start();
   require 'include/db.connect.php';

   $insertData=new InsertData();
   $tasklist=new Users();
   $tasklists=$tasklist->getTheData("SELECT * FROM `task`");
   $finished=$tasklist->getTheData("SELECT * FROM `task` where pending=0");
   $pending=$tasklist->getTheData("SELECT * FROM `task` where pending=1");

  
  
  
   
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<style>
  .addbtn{
    display: flex;
    justify-content: flex-end;
  }
  .t{
    display: flex;
 
  }
  .notask{
    display:flex;
    justify-content:center;
  }
</style>
  <title>Todo</title>

</head>

<body>
 <?php
  if(isset($_POST["submit"])){
      
    $title=$_POST['title'];
    $description=$_POST['description'];
    $result= $insertData->query("INSERT INTO `task` (`tasktitle`, `taskdesc`, `pending`) VALUES ('$title', '$description', '1');");
    header("location:index.php");
    echo"hello";
 
 }
 if(isset($_POST["delete"])){
  echo '<script language="javascript">';
    echo 'alert("message successfully sent")';
   echo '</script>';
   $delid=$_POST['taskid'];
   $result= $insertData->query(" DELETE FROM task WHERE taskid=$delid;");
   $_SESSION['delete']="true";
   
   header("location:index.php");

   
 }
 if(isset($_POST["finished"])){
  $delid=$_POST['taskid'];
  $insertData->query("UPDATE `task` SET  `pending` = '0' WHERE `task`.`taskid` = $delid;");
  $_SESSION['finish']="true";
  header("location:index.php");
 }
 ?>



  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/todo/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Task Name</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Task Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><img src="/crud/logo.svg" height="28px" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>

      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
<?php
  
  

  ?>
 
  <div class="container my-4 w-50">
    <div class="t">
    <h2>Add Task</h2>
  </div>
    <form action="/todo/index.php" method="POST" >
      <div class="form-group">
        <label for="title">Task Title </label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>

      <div class="form-group">
        <label for="desc">Task Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
     <div class="addbtn">
      <button type="submit" class="btn btn-outline-success" name="submit" >Add Task</button>
    </div>
    </form>
  </div>
  
 
  
  <div class="container my-4">

  <div class="t">
  <button type="button" class="btn btn-danger my-2">Pending Task</button>
  </div>
  
    <table class="table" id="myTable">
      <thead>
        <tr>
          
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col ">Actions</th>
          <th scope="col "></th>
        </tr>
      </thead>
      <tbody>
      
       <?php
          if (empty($pending)) {
            echo"
            <div class='notask'>
            <h2>No Pending Task</h2>
            </div>";
          }
          else{
          
         foreach($tasklists as $list)
          {
            
            if($list['pending']==1){
            echo "<tr>
            
            <td>". $list['tasktitle'] . "</td>
            <td>". $list['taskdesc'] . "</td>
            <form action='/todo/index.php' method='POST' >
            <input  type='hidden' name='taskid' value='".$list['taskid']."'>
            <td> <button class='delete btn btn-sm btn-danger'name='delete' >Delete</button>  </td>
            
    <td><button class='delete btn btn-sm btn-success ' name='finished' >Finished</button></td>
    </form>
            
          </tr>";
            }
          
          }

          }

        ?>


      </tbody>
    </table>
  </div>
  
  <div class="container my-4">

  <div class="t">
  <button type="button" class="btn btn-success my-2">Completed Task</button>
  </div>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
       <?php
       
        if (empty($finished)) {
          echo"
          <tr>
          <div class='notask'>
          <h2>No finshed task</h2>
          </div>
          </tr>";
          
        }
       
       else{
        $i=0;
         foreach($tasklists as $list)
          {
            
            if($list['pending']==0){
            echo "<tr>
            <th scope='row'>". $i. "</th>
            <td>". $list['tasktitle'] . "</td>
            <td>". $list['taskdesc'] . "</td>
            <form action='/todo/index.php' method='POST' >
            <input  type='hidden' name='taskid' value='".$list['taskid']."'>
            <td> <button class='delete btn btn-sm btn-danger' name='delete' >Delete</button>  </td>

            </form>
          </tr>";
          $i++;
          }
          
        }
        }

        ?>


      </tbody>
    </table>
  </div>
  <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></sodium_crypto_sign_ed25519_pk_to_curve25519>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  
</body>

</html>
