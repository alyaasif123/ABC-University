<?php

class DbController{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->db_hostname 	= "localhost";
		$this->db_user 		= "root";
		$this->db_password 	= "";
		$this->db_database 	= "clz_role_based";

		$this->db_con = new MySQLi($this->db_hostname,$this->db_user,$this->db_password,$this->db_database);
    
		if ($this->db_con->connect_errno) {
		 die("ERROR : -> ".$this->db_con->connect_error);
		}
	}

	//check username exits
	public function checkUsernameOrPassword($column_name,$user_name,$user_type)
	{
		if ($user_type == 1) {
			$table_name = 'students';	
		}
		else{
			$table_name = 'staff';
		}

		$check_email = $this->db_con->query("SELECT User_Name FROM $table_name WHERE $column_name='$user_name' AND Active=1");
 		$count=$check_email->num_rows;

 		return $count;
	}

	//get department details
	public function getDepartmentDetailsById($value)
	{
		$query = $this->db_con->query("SELECT Name,Acadamic_Y_Id FROM departments WHERE Dep_Id='$value'");
 		$result=$query->fetch_array();

 		return $result;
	}

	//get student details by id
	public function getStudentDetailsById($id)
	{
		$query = $this->db_con->query("SELECT F_Name,L_Name,Image FROM students WHERE Student_Id='$id'");
 		$result=$query->fetch_array();

 		return $result;
	}

	//get list of students
	public function getStudentDetails()
	{
		$query = $this->db_con->query("SELECT * FROM students ORDER BY Student_Id DESC");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	//get staff details by id
	public function getStaffDetailsById($id)
	{
		$query = $this->db_con->query("SELECT F_Name,L_Name,Image FROM staff WHERE Staff_Id='$id'");
 		$result=$query->fetch_array();

 		return $result;
	}

	//get list of staff
	public function getStaffDetails()
	{
		$query = $this->db_con->query("SELECT * FROM staff ORDER BY Staff_Id DESC");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	//get department details
	public function getIdeaList($offset, $limit)
	{
		$query = $this->db_con->query("SELECT * FROM `ideas` ORDER BY Added_Date DESC limit $offset, $limit");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	//get department details
	public function getIdeaById($id)
	{
		$query = $this->db_con->query("SELECT * FROM `ideas` WHERE Idea_Id = '".$id."'");
 		$result=$query->fetch_array();
 		return $result;
	}

	//Get total number of records 
	public function getIdeaListCount()
	{
		$query = $this->db_con->query("SELECT COUNT(*) as 'total_rows' FROM `ideas` ORDER BY Added_Date DESC");
 		$result=$query->fetch_array();

 		return $result;
	}

	//get category details
	public function getCatgeoryDetails()
	{
		$query = $this->db_con->query("SELECT * FROM categories");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	//get user details
	public function getUserDetails($password,$user_name,$user_type)
	{
		if ($user_type == 1) {
			$table_name = 'students';
			$query = $this->db_con->query("SELECT * FROM $table_name WHERE User_Name='$user_name' AND Password='$password' AND Active=1");	
		}
		else{
			$table_name = 'staff';
			$query = $this->db_con->query("SELECT * FROM staff s INNER JOIN user_roles u ON u.User_Role_Id = s.User_Role_Id WHERE s.User_Name='$user_name' AND s.Password='$password' AND s.Active=1 ");
		}

 		$result=$query->fetch_array();

 		return $result;
	}

	//insert idea
	public function insertIdea($topic,$description,$anonymous_status,$file,$user_id,$category_id,$acadamic_y_id)
	{
		$today = date("Y-m-d H:i:s");
		$query = $this->db_con->query("INSERT INTO `ideas`(`Idea_Topic`, `Idea_Description`, `Anonymous_Status`, `Added_Date`, `Upload_File`, `Idea_View_count`, `Student_Id`, `Category_Id`, `Acadamic_Y_Id`) VALUES ('".$topic."','".$description."','".$anonymous_status."','".$today."','".$file."','0','".$user_id."','".$category_id."','".$acadamic_y_id."')");
 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	//get likes, dislikes by idea id 
	public function getCountLikeDislikeById($status,$idea_id)
	{
		$query = $this->db_con->query("SELECT count(*) as count FROM likes_dislike WHERE Status = '".$status."' AND Idea_Id = '".$idea_id."'");
 		$result = $query->fetch_array();
 		return $result['count'];
	}

	//get likes or dislike activated to idea by user
	public function getLikeDislikeIdeaByUser($user_id,$idea_id,$user_type)
	{
		$query = $this->db_con->query("SELECT Status FROM likes_dislike WHERE User_Id = '".$user_id."' AND Idea_Id = '".$idea_id."' AND User_Type = '".$user_type."'");
 		$result = $query->fetch_array();
 		return $result;
	}

	//delete likes or dislike by user and idea
	public function deleteLikeDislikeByIdeaUser($user_id,$idea_id,$user_type)
	{
		$query = $this->db_con->query("DELETE FROM `likes_dislike` WHERE User_Id = '".$user_id."' AND Idea_Id = '".$idea_id."' AND User_Type = '".$user_type."'");
 		return $query;
	}

	//delete likes or dislike by user and idea
	public function getCommentByIdeaByStudentOrAll($idea_id,$user_type)
	{
		if ($user_type == 2) {
			$query = $this->db_con->query("SELECT COUNT(*) as item_count FROM comments WHERE Idea_Id = '".$idea_id."' AND Student_Id IS NOT NULL");
		}else{
			$query = $this->db_con->query("SELECT COUNT(*) as item_count FROM comments WHERE Idea_Id = '".$idea_id."'");
		}

		$result = $query->fetch_array();
		
 		return $result;
	}

	public function saveLikeDislike($user_id,$idea_id,$user_type,$status)
	{
		$query = $this->db_con->query("INSERT INTO `likes_dislike`(`Status`,`Idea_Id`, `User_Id`, `User_Type`) VALUES ('".$status."','".$idea_id."','".$user_id."','".$user_type."')");

 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	//insert view count to idea
	public function addViewCountToIdea($idea_id)
	{
		$query = $this->db_con->query("UPDATE `ideas` SET `Idea_View_count`=Idea_View_count+1 WHERE `Idea_Id`='".$idea_id."'");

 		return $query;
	}

	public function getCommentsById($idea_id)
	{

		$query = $this->db_con->query("SELECT * FROM comments WHERE Idea_Id = '".$idea_id."' ORDER BY Added_Date DESC");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	public function getUserRoles()
	{
		$query = $this->db_con->query("SELECT * FROM user_roles");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	public function getDepartment()
	{
		$query = $this->db_con->query("SELECT * FROM departments");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	public function saveComment($user_id,$idea_id,$user_type,$comment,$status)
	{
		if ($user_type == 2) {
			$query = $this->db_con->query("INSERT INTO `comments`(`Comment_Description`, `Anonymous_Status`, `Idea_Id`, `Student_Id`) VALUES ('".$comment."','".$status."','".$idea_id."','".$user_id."')");
		}else{
			$query = $this->db_con->query("INSERT INTO `comments`(`Comment_Description`, `Anonymous_Status`, `Idea_Id`, `Staff_Id`) VALUES ('".$comment."','".$status."','".$idea_id."','".$user_id."')");
		}
		

 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	public function getAcadamicYear()
	{

		$query = $this->db_con->query("SELECT * FROM acadamic_year ORDER BY Active DESC");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}


	public function getAcadamicYearById($id)
	{

		$query = $this->db_con->query("SELECT * FROM acadamic_year WHERE Acadamic_Y_Id = '".$id."'");
		$result = $query->fetch_array();
		
 		return $result;
	}

	public function updateAcadamicYear($id,$year,$title,$closure_date,$final_closure_date,$status)
	{
		if ($status == 1) {
			$query = $this->db_con->query("UPDATE `acadamic_year` SET `Active`='0'");
		}

		$query = $this->db_con->query("UPDATE `acadamic_year` SET `Year`='".$year."',`Title`='".$title."',`Final_Closure_Date`='".$final_closure_date."',`Closure_Date`='".$closure_date."',`Active`='".$status."' WHERE `Acadamic_Y_Id`='".$id."'");

 		return $query;
	}


	public function wordLimit($string,$limit,$id)
	{
		// strip tags to avoid breaking any html
		$string = strip_tags($string);
		if (strlen($string) > $limit) {

		    // truncate string
		    $stringCut = substr($string, 0, $limit);
		    $endPoint = strrpos($stringCut, ' ');

		    //if the string doesn't contain any space then it will cut without word basis.
		    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
		    $string .= '... <a onclick="viewPage('.$id.')">Read More</a>';
		}
		return $string;
	}

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) 
	{
	    $str = @trim($str);
	    if(get_magic_quotes_gpc()) {
	        $str = stripslashes($str);
	        $str = strip_tags($str);
	    }
	    return mysqli_real_escape_string($this->db_con,$str);
	}

	function time_elapsed_string($datetime, $full = false) 
	{
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

}
?>