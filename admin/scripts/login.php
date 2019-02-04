<?php 
function login($username, $password, $ip){
	require_once('connect.php');

	//Check if user exists
	
	$check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name=:user_name';

	$user_set = $pdo->prepare($check_exist_query);

	$user_set->execute(
		array(
			':user_name'=>$username
		)
	);

	if($user_set->fetchColumn()>0){
		//When user exists, then check if user info is validated
		$get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username AND user_pass = :password';
		$get_user_set = $pdo->prepare($get_user_query);

		$get_user_set->execute(
			array(
				':username'=>$username,
				':password'=>$password
			)
		);

		while($found_user = $get_user_set->fetch(PDO::FETCH_ASSOC)){
			$id = $found_user['user_id'];
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name'] = $found_user['user_fname'];

			//TODO: finish the following lines of code
			// - $update_ip_query should be the SQL QUERY that
			// update the tbl_user and set the user_ip = $ip
			// - Keep in mind we need to do prepare in here
			// and binding the actual $ip variable within execute method

			$update_ip_query = '';
			$update_ip_set = $pdo->prepare($update_ip_query);
			$update_ip_set->execute(
				array()
			);
		}


		if(empty($id)){
			$message = 'Login Failed';
			return $message;
		}

		redirect_to('index.php');
	}else{
		$message = 'User does not exists';
		return $message;
	}
}
?>