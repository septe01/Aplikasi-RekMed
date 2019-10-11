<?php


class USER
{
	private $db;
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	public function base_url($string){
		echo "http://localhost/bundamulya/panel/home.php?page=".$string;
	}
	public function redirect($url)
	{
		
		header("Location: $url");
	}
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']) && isset($_SESSION['nama']) && isset($_SESSION['status']))
		{
			$arr = ['user' => $_SESSION['nama'],
					'status' => $_SESSION['status']
					];
			return $arr;
		}
	}
	public function register($uname,$ustatus,$upass)
	{
			// $new_password = sha1($upass);


			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->db->prepare("INSERT INTO tbl_user(nama_user,password_user,status_user)VALUES(:uname, :upass, :ustatus)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":ustatus", $ustatus);
			$stmt->bindparam(":upass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;		
	}

	public function login($uname,$upass)
	{
		// $new = sha1($upass);

		$stmt = $this->db->prepare("SELECT * FROM tbl_user WHERE nama_user='$uname'");
		$stmt->execute();
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$_SESSION['error'] = "";
		if($stmt->rowCount() > 0){	

			if(password_verify($upass, $userRow['password_user'])){
				$_SESSION['user_session'] = $userRow['kode_user'];
				$_SESSION['nama'] = $userRow['nama_user'];
				$_SESSION['status'] = $userRow['status_user'];
				return true;
			}else{
				$_SESSION['error']	= "Password Anda Salah !";
				return false;
			}
			
		}else{
			$_SESSION['error']	= "Username Anda Salah !";
			return false;
		}
	}

	public function logout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		unset($_SESSION['nama']);

		return true;
	}

}


?>