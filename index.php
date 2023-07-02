<?php

$conn = mysqli_connect("localhost", "root", "", "crud");

$name_Err = $phone_Err = $email_Err = $password_Err = $address_Err = $msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
        $name_Err = "Name is Required";
    } elseif (!preg_match("/^[a-z A-z]*$/", $_POST['name'])) {
        $name_Err = "Only alphabets and whitespace are allowed.";
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['phone'])) {
        $phone_Err = "Phone is Required";
    } elseif (!preg_match('/^[0-9]*$/', $_POST['phone'])) {
        $phone_Err = "Invalid Phone Number";
    } else {
        $phone = $_POST['phone'];
    }

    if (empty($_POST['email'])) {
        $email_Err = "Email is Required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_Err = "Invalid email ID";
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['address'])) {
        $address_Err = "address is Required";
    } else {
        $address = $_POST['address'];
    }

    if (empty($name_Err) && empty($phone_Err) && empty($email_Err) && empty($address_Err)) {
        $insert_qry = "INSERT into tabdata(name,phone,email,address) values('$name','$phone','$email','$address')";
        if (mysqli_query($conn, $insert_qry)) {
            $msg = '<div class="alert alert-success" role="alert">
        Record inserted successfully! 
      </div>';
        } else {
            $msg = '<div class="alert alert-warning" role="alert">
        Something went Wrong!
      </div>';
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET["id"];

    $delete_qry = 'DELETE FROM tabdata WHERE id ="' . $id . '"';
    $delete_result = mysqli_query($conn, $delete_qry);
    if ($delete_result) {
        $msg = '<div class="alert alert-success" role="alert">
    Record successfully Deleted! 
  </div>';
    } else {
        $msg = '<div class="alert alert-warning" role="alert">
    Something went Wrong! Record was not Deleted ! 
  </div>';
    }
}

$SelectQry = 'SELECT * FROM tabdata';
$select_result = mysqli_query($conn, $SelectQry);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <?= $msg ?>
        <form class="row g-3" action="#" method="post">

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Name <span class="text-danger"><?= $name_Err ?></span></label>
                <input type="name" name="name" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Phone <span class="text-danger"><?= $phone_Err ?></span></label>
                <input type="text" name="phone" class="form-control" id="inputPassword4">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email <span class="text-danger"><?= $email_Err ?></span></label>
                <input type="email" name="email" class="form-control" id="inputEmail4">
            </div>


            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Address <span class="text-danger"><?= $address_Err ?></span></label>
                <input type="text" name="address" class="form-control" id="inputAddress">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Insert</button>
            </div>
        </form>

    </div>
    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($select_result) > 0) {
                    $a = 1;
                    while ($row = mysqli_fetch_assoc($select_result)) {
                ?>
                        <tr>
                            <th scope="row"><?= $a ?></th>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['address'] ?></td>
                            <td>
                                <form action="#" method="post">
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm m-1">Edit</a>
                                    <a href="index.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm m-1">Delete</a>
                                </form>
                            </td>

                        </tr>
                    <?php
                        $a++;
                    }
                } else {
                    ?>
                    <tr>
                        <td>No Record</td>
                    </tr>
                <?php
                }
                ?>


            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>