<!DOCTYPE html>
<html>
  <head>
    <?php
      $connection=new mysqli("localhost", "root", "", "myDatabase");
      if($connection->connect_error){
        echo "Error with db connection.";
      }
    ?>
    <meta charset="UTF-8">
    <title>Facebook login form </title>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
  </head>
  <body style="background-color: #E2E2E2;">
    <div class="modal" id="modal" >
      <div class="modal-main" >
          <div class="row">
            <form class="form" action="engine.php?act=reg" method="POST">
              <div class="col-xs-6">
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Name:</label>
                    <input required type="text" class="form-control" name="name"/>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Surname:</label>
                    <input required type="text" class="form-control" name="surname"/>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Login:</label>
                    <input required type="text" class="form-control" id="usr" name="login"/>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="pwd">Password:</label>
                    <input required type="password" class="form-control" id="pwd" name="password"/>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Email:</label>
                    <input required type="email" class="form-control" name="email"/>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="usr">City:</label>
                  <?php 
                    $query=$connection->query("SELECT co.name country_name, c.name FROM sncountries co LEFT JOIN sncities c ON c.country_id = co.id"); 
                    $temp = ""; 
                  ?> 
                  <select required name="city" class="form-control input-lg" > 
                  <?php 
                    while($row=$query->fetch_object()){ 
                      if($temp==""){
                  ?> 
                        <optgroup label="<?php echo $row->country_name ?>"> 
                  <?php 
                      }else if($row->country_name!=$temp){ 
                        $num++; 
                  ?> 
                        </optgroup> 
                        <optgroup label="<?php echo $row->country_name ?>"> 
                  <?php 
                      } 
                  ?>
                      <option value="<?php echo $row->name ?>"><?php echo $row->name ?></option> 
                  <?php
                      $temp = $row->country_name; 
                    }
                  ?> 
                    </optgroup> 
                  </select>
                  </div>
              </div>
              <div class="col-xs-6">
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Age:</label>
                    <select required name="age" class="form-control input-lg">
                      <?php for($i=0;$i<150;$i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';  
                      }?>
                    </select>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Gender:</label>
                    <select required name="gender" class="form-control input-lg" size="1">
                      <option value="1">Male</option>
                      <option value="2">Female</option>
                    </select>
                  </div>
                  <div class="form-group" style="width: 500px">
                    <label for="usr">Date:</label>
                    <input required type="date" max="2016-08-13" min="1940-01-01" class="form-control" name="date"/>
                  </div>
                  <input type="submit" value="register" class="btn btn-success"/>
                  <a href="#" id="close" class="btn btn-primary">back</a>
              </div>
            </form>
          </div>
      </div>
    </div>
    <section class="login-form-wrap">
      <h1>Facebook</h1>
      <form class="login-form" action="engine.php?act=login" method="post">
        <label>
          <input type="text" style="width: 300px" name="login" required placeholder="Login">
        </label>
        <label>
          <input type="password" style="width: 300px" name="password" required placeholder="Password">
        </label>
        <input type="submit" value="Login">
      </form>
      <h5><button onclick="show()" class="btnreg" >Register</button></h5>
    </section>
    <?php
    if(isset($_GET['error'])){
      if($_GET['error']==1){
    ?>
        <div class="row" style="margin-left: 600px; color: red;">
          <label for="urs">Wrong login or password</label>
        </div>
    <?php
      }
    }
    ?>


  <script>
    var modal = document.getElementById("modal");
    var span = document.getElementById("close");

    function show(){
      modal.style.display = "block";
    }

    span.onclick = function () {
      modal.style.display = "none";
    }

  </script>

  </body>
</html>
