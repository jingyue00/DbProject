<?PHP
	session_start();
	
	//connect to database
	require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}

	//get product and customer
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
	$loginname = $_SESSION['loginname'];
	$usrname = $_POST["usrname"];
	$password = $_POST["password"];
	$md5password = md5($password);
	$hometown = $_POST["hometown"];
	$target_path = "/var/www/html/DbProject/img/";
    $target_path = $target_path . basename( $_FILES['post']['name']); 
    //echo "<br>";
    //echo $target_path;
    //echo "<br>";
    if(move_uploaded_file($_FILES["post"]["tmp_name"], $target_path))
    {
       //echo "upload complete";
    }
    else
    {
       //echo "move_uploaded_file failed";
       exit();
    }

    //echo "<img src='img/".$_FILES["post"]["name"]."'>";

    $post = $_FILES["post"]["name"];	
	
	
	$usr = $conn->prepare("select * from USER where loginname= ?");
	$usr->bind_param("s", $loginname);
	$usr->execute();
	$prow = mysqli_fetch_array($usr->get_result(), MYSQLI_BOTH);
	
	$updatepur = $conn->prepare("UPDATE USER Set name=?, password=?, hometown=?, post=? WHERE loginname= ?");        
	$updatepur->bind_param("sssss", $usrname, $md5password, $hometown, $post, $loginname);
	$updatepur->execute();
	$updaterowu = mysqli_fetch_array($updatepur->get_result(),MYSQLI_BOTH);
	
	if (!$updaterowu )
	{
		header("Location:mypage.php");
		exit;
	}
?>
