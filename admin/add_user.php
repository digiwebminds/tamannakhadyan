<?php
session_start();
if (isset($_SESSION['username'])){
    $role = $_SESSION['role'];
    if($role == 0){
      header('location:loans.php') ;
    }elseif($role == 1){
      header('location:loans.php') ;
    }elseif($role == 2){
    //   header('location:dashboard.php') ;
    }
}else{
      header('location: ../index.php');
}

if(time() - $_SESSION['logintime'] > 600) { //subtract new timestamp from the old one
    unset($_SESSION['username'], $_SESSION['logintime']);
    // $_SESSION['logged_in'] = false;
    header("Location:../index.php"); //redirect to index.php
    exit;
  } else {
    $_SESSION['logintime'] = time(); //set new timestamp
  }
?>
<?php

require_once("../include/connect.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM customers WHERE id = $id";
    $result = mysqli_query($conn,$sql2);
    $user = mysqli_fetch_assoc($result);
}

if(isset($_POST['submit'])){
    $dor = $_POST['dor'];
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    if(isset($_FILES['photo'])){
        $photo = $_FILES['photo'];
    }
    $gname = $_POST['gname'];
    $gfname = $_POST['gfname'];
    $gaddress = $_POST['gaddress'];
    $gcity = $_POST['gcity'];
    $gphone = $_POST['gphone'];
    if(isset($_FILES['gphoto'])){
        $gphoto = $_FILES['gphoto'];
    }
    $sname = $_POST['sname'];
    $documents = $_POST['documents'];

    $imageupload = null;
    if(isset($_FILES['photo'])){
        $imagefilename = $photo['name'];
        $imagetemp = $photo['tmp_name'];
        $imageerror = $photo['error'];
        $image_seperate = explode('.',$imagefilename);
        $image_extension = strtolower(end($image_seperate));
        $extension = array("jpg","jpeg","png");
        if(in_array($image_extension,$extension)){
            $imageupload = '../uploaded/' . $imagefilename ;
            move_uploaded_file($imagetemp,$imageupload);
        }
    }
    $gimageupload = null;
    if(isset($_FILES['gphoto'])){
        $gimagefilename = $gphoto['name'];
        $gimagetemp = $gphoto['tmp_name'];
        $gimageerror = $gphoto['error'];
        $gimage_seperate = explode('.',$gimagefilename);
        $gimage_extension = strtolower(end($gimage_seperate));
        $extension = array("jpg","jpeg","png");
        if(in_array($gimage_extension,$extension)){
            $gimageupload = '../uploaded/' . $gimagefilename ;
            move_uploaded_file($gimagetemp,$gimageupload);
        }
    }

    if(isset($_GET['id'])){
        $uid = $_GET['id'];
        $sql = "UPDATE customers SET dor='$dor', name='$name', fname='$fname', address='$address', city='$city', phone='$phone', gname='$gname', gfname='$gfname', gaddress='$gaddress', gcity='$gcity', gphone='$gphone', sname='$sname', documents='$documents' WHERE id='$uid'";
    }else{
        $sql = "INSERT INTO `customers` (dor,name,fname,address,city,phone,photo,gname,gfname,gaddress,gcity,gphone,gphoto,sname,documents) VALUES ('$dor','$name','$fname','$address','$city','$phone','$imageupload','$gname','$gfname','$gaddress','$gcity','$gphone','$gimageupload','$sname','$documents')";
    }

    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: customers.php");
        exit();
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <title>Add Customer</title>
</head>

<body>
    <?php
    include ("../include/navbar.php");
    date_default_timezone_set("Asia/Calcutta");
    ?>
    <section class="bg-gray-400">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Add Customers
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" enctype="multipart/form-data" method="post">
                        <div>
                            <label for="dor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Registration</label>
                            <input type="date" name="dor" id="dor" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value="<?php if(isset($_GET['id'])){echo $user['dor'];} else{echo date("Y-m-d");} ?>">
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['name']."'";} ?> required>
                        </div>
                        <div>
                            <label for="fname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Father's Name</label>
                            <input type="text" name="fname" id="fname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['fname']."'";} ?> required>
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            <input type="textarea" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['address']."'";} ?> required>
                        </div>
                        <div>
                            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                            <input type="text" name="city" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['city']."'";} ?> required>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone No.</label>
                            <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['phone']."'";} ?> required placeholder="+91 ">
                        </div>
                        <?php if(!isset($_GET['id'])){ ?>
                        <div>
                            <label for="photo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Photo</label>
                            <input type="file" name="photo" id="photo" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <?php } ?>
                        <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
                        <div>
                            <label for="gname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Guaranter Name</label>
                            <input type="text" name="gname" id="gname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['gname']."'";} ?> >
                        </div>
                        <div>
                            <label for="gfname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Guaranter Father Name</label>
                            <input type="text" name="gfname" id="gfname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['gfname']."'";} ?> >
                        </div>
                        <div>
                            <label for="gaddress" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guaranter Address</label>
                            <input type="textarea" name="gaddress" id="gaddress" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['gaddress']."'";} ?> >
                        </div>
                        <div>
                            <label for="gcity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guaranter City</label>
                            <input type="text" name="gcity" id="gcity" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['gcity']."'";} ?> >
                        </div>
                        <div>
                            <label for="gphone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guaranter Phone No.</label>
                            <input type="text" name="gphone" id="gphone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+91 " <?php if(isset($_GET['id'])){echo "value='".$user['gphone']."'";} ?> >
                        </div>
                        <?php if(!isset($_GET['id'])){ ?>
                        <div>
                            <label for="gphoto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guranter photo</label>
                            <input type="file" name="gphoto" id="gphoto" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <?php } ?>
                        <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
                        <div>
                            <label for="sname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shop name</label>
                            <input type="text" name="sname" id="sname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['sname']."'";} ?> >
                        </div>
                        <div>
                            <label for="documents" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documents</label>
                            <input type="textarea" name="documents" id="documents" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if(isset($_GET['id'])){echo "value='".$user['documents']."'";} ?> >
                        </div>
                        <button type="submit" name="submit" id="submit" class="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800"><?php if(isset($_GET['id'])){echo "Update Customer";}else{ echo "Add Customer";} ?></button>
                        <?php
                        if(isset($_GET['id'])){
                            echo '<a href="customers.php" class="w-full text-white bg-blue-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800">Cancel</a>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
<?php
    include ("../include/footer.php");
?>
</html>