<?php
$conn = mysqli_connect("localhost", "root", "", "crud");

$name_Err = $phone_Err = $email_Err = $password_Err = $address_Err = $msg = '';

 
$selectQue = "SELECT * FROM tabdata where id= '".$_GET['id']."'";
$select_result = mysqli_query($conn, $selectQue);
if(mysqli_num_rows($select_result)>0){
    $row = mysqli_fetch_assoc($select_result);
    // $name = $row['name'];
    // $phone = $row['phone'];
    // $email = $row['email'];
    // $address=$row['address'];

    
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
        $insert_qry = "UPDATE tabdata set name='$name', phone='$phone', email='$email',address='$address' where id= '".$_GET['id']."'";
        if (mysqli_query($conn, $insert_qry)) {
            $msg = '<div class="alert alert-success" role="alert">
        Record inserted successfully! 
      </div>';
      header("Location: index.php");
        } else {
            $msg = '<div class="alert alert-warning" role="alert">
        Something went Wrong!
      </div>';
        }
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container mt-5">
        <form class="row g-3" action="#" method="post">

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Name <span class="text-danger"><?= $name_Err ?></span></label>
                <input type="name" name="name" value="<?= $row['name']?>" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Phone <span class="text-danger"><?= $phone_Err ?></span></label>
                <input type="text" name="phone"  value="<?= $row['phone']?>" class="form-control" id="inputPassword4">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email <span class="text-danger"><?= $email_Err ?></span></label>
                <input type="email" name="email"  value="<?= $row['email']?>" class="form-control" id="inputEmail4">
            </div>


            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Address <span class="text-danger"><?= $address_Err ?></span></label>
                <input type="text" name="address"  value="<?= $row['address']?>" class="form-control" id="inputAddress">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Insert</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>