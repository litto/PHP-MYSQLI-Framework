<?php
include("db.php");
/*
 * @category  Database Access
 * @package   MysqliDb
 * @author    Litto chacko <littochackomp@gmail.com>
 * @copyright Copyright (c) 2010-2016
 * @link      https://github.com/litto/PHP-MYSQLI-Framework/ 
 * @version   2.0-master
 */

if(isset($_POST['submit'])){

	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];

	    $key    =   rand(0,9999).rand(111,999);
        $crypt  = new Crypt; 
        $crypt->crypt_key($key);                                        // Get encryption key
        $password = $crypt->encrypt($password);

	    if(trim($name)=='' || trim($password)=='' || trim($email)==''){
        $message    =   new Message('Enter mandatory fields','error');
        $message->setMessage();
        
    }else{

    	        $absDirName =   dirname(__FILE__).'/uploads';
            $relDirName =   '../uploads';
        
            $uploader   =   new Uploader($absDirName.'/');
            $uploader->setExtensions(array('jpg','jpeg','png','gif'));
            $uploader->setSequence('banner');
            $uploader->setMaxSize(10);
            if($uploader->uploadFile("txtFile")){

                 $image     =   $uploader->getUploadName(); 
                
            } else{
            	$image='user.png';
            }



// $obj->fullname = $name;
// $obj->email = $email;
// $obj->password =$password;
// $obj->key=$key;
// $obj->image = $image;
// $obj->status=1;
$data=array('fullname'=>$name,'email'=>$email,'password'=>$password,'key'=>$key,'image'=>$image,'status'=>'1');
$obj = new employee($data);
$lastid=$obj->save();

header("Location:index.php");
exit;

    }
}

?>


<html>
<head>
	<title>CRUD FRAMEWORK</title>

</head>
<body>
<div>
<ul>
<li><a href="index.php">List</a></li>
<li><a href="add.php">Create</a></li>
</ul>
</div>
<form method="post" enctype="multipart/form-data" action="add.php">

<table border="1" cellpadding='1' cellspacing='1' width="100%">
<tr><td>Full Name:</td><td>  <input type="text" name="name"></td></tr>
<tr><td>Email:</td><td><input type="text" name="email"></td></tr>
<tr><td>Password:</td><td><input type="password" name="password"></td></tr>
<tr><td>Image:</td><td><input type="file" name="txtFile"></td></tr>
<tr><td></td><td><input type="submit" name="submit"/> </td></tr>
</table>
</form>

</body>
</html>
