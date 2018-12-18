<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php

            // A routine to update users data - working fine!
            // $user = User::find_user_by_id(9);
            // $user->username="vibrambilla";
            // $user->password="therainman";
            // $user->first_name="vittorio";
            // $user->last_name="brambilla";
            // $user->update();

            // $user = new User();
            // $user->username="joglenn";
            // $user->password="testpilot";
            // $user->first_name="scott";
            // $user->last_name="crossfield";
            // $user->update();
            //$user->save();

            // $user = User::find_user_by_id(4);
            // $user->username="ivanoreb";
            //
            // $user->save();
            //$user->delete();


            // $user->last_name="Ickx";
            // $user->update();

            //Following lines of code are using create() method to make a new user
            // $user = new User();
            // $user->username = "jyoung";
            // $user->password = "columbia";
            // $user->first_name = "John";
            // $user->last_name = "Young";
            //
            // $user->create();


            /*
            if($database->connection){
              echo "Database connection established!"."<br>";
            }
            */

            /*
            This was part of first solution without User class
            $sql = "SELECT * FROM users WHERE _id=1";
            $result = $database->query($sql);
            $user_found = mysqli_fetch_array($result);
            echo $user_found['username'];
            */

            // After making method static no need to instantiate the class User
            //$user = new User();

            // $users = User::find_all();
            // foreach ($users as $user) {
            //   // code...
            //   echo $user->username."<br>";
            // }

            // while($row = mysqli_fetch_array($result_set)){
            //   echo $row['username']."<br>";
            // }

            //New function used this one commented out
            // $found_user = User::find_user_by_id(2);
            // echo $found_user->username;

            // $user = User::instantiation($found_user);

            // $user = new User();
            //
            // $user->_id = $found_user['_id'];
            // $user->username = $found_user['username'];
            // $user->password = $found_user['password'];
            // $user->first_name = $found_user['first_name'];
            // $user->last_name = $found_user['last_name'];

            //echo $found_user['username'];
            // echo $user->last_name;

            $photo = Photo::find_all();
            foreach ($photo as $value) {
              // code...
              echo $value->title . " " . $value->description . "<br>";
            }




            ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->
