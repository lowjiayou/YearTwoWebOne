<?php
	// session functions
	session_start();
	include_once 'showEventFunction.php';
	if(isset($_SESSION['logged-in'])){
		//show logout button only
		createLogoutForm();
	}else{
		//show login 
		createLoginForm();
	}
	
	// if login
	if(isset($_POST['loginBtn'])){
		login();
	}else if(isset($_POST['logoutBtn'])){
		// if logout
		session_destroy();
		// go to url
		$url=$_SERVER['REQUEST_URI'];
		header("Location: $url");
	}
?><?php	
	// main function
	function login(){
		include_once ('database_conn.php');
		// check is form filled
		if(isFormFilled()){
			// if not filled, stop
			return;
		}
		$uid=sanitizeData($_POST['username']);
		$pswd=sanitizeData($_POST['password']);
		
		$columnLengthSql="
			SELECT COLUMN_NAME, CHARACTER_MAXIMUM_LENGTH
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME =  'te_users'
			AND (column_name =  'username'
			OR column_name =  'passwd')";
		$COLUMN_LENGTH=getColumnLength($conn, $columnLengthSql);
		$isError=false;
		$errMsg[]=validateStringLength($uid, $COLUMN_LENGTH['username']);//uid
		$errMsg[]=validateStringLength($pswd,$COLUMN_LENGTH['passwd']);//pswd
		for($i=0; $i<count($errMsg); $i++){
			if (!($errMsg[$i]===true)){
				echo "$errMsg[$i]";
				$isError=true;
			}
		}
		//if contain error, halt continue executing the code
		if($isError)
			return;
		// check is uid exist
		$checkUIDSql = "SELECT passwd, salt FROM te_users WHERE username = ?";
		$stmt = mysqli_prepare($conn, $checkUIDSql); 
		mysqli_stmt_bind_param($stmt, "s", $uid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		
		if (mysqli_stmt_num_rows($stmt) <= 0) {
			echo "Sorry we don't seem to have that username.";
			return;
		}
		mysqli_stmt_bind_result($stmt, $getHashpswd, $getSalt);
		while (mysqli_stmt_fetch($stmt)) {
			$hashPswd = $getHashpswd;
			$salt= $getSalt;
		}
		
		// if exist, then get salt and db hashed password
		// create hash based on password 
		// hash pswd using sha256 algorithm
		// concat salt in db by uid
		// hash using sha256 algorithm
		$pswd=hash("sha256",($salt.hash("sha256",$pswd)));
		// check does it match with hased password from db
		if(strcmp($pswd,$hashPswd)===0){
			echo "Success login<br/>";
			// add session
			$_SESSION['logged-in'] = $uid;
			// go to url
			$url=$_SERVER['REQUEST_URI'];
			header("Location: $url");
		}else{
			echo "Fail login<br/>";
		}
	}
?>
<?php
	// supportive function
	function createLoginForm(){
		$formName =htmlspecialchars($_SERVER["PHP_SELF"]);//$formName
		echo "<div id=\"loginForm\"><form method=\"post\" action=\"#\">".
		"<div>Username: ".createTextField("username", "").
		"Password: ".createTextField("password", "").
		"<input type=\"submit\" name=\"loginBtn\" value=\"Login\"></input></div>
		</form></div>
		";
		createTextField("username", "");
		createTextField("password", "");
	}
	function createLogoutForm(){
		$formName =htmlspecialchars($_SERVER["PHP_SELF"]);
		echo "<div id=\"loginForm\"><form method=\"post\" action=\"$formName\"><div>
		<input type=\"submit\" name=\"logoutBtn\" value=\"Logout\"></input></div>
		</form></div>
		";
	}
?>