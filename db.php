<?php

class DbController{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->db_hostname 	= "localhost"; //Database host name
		$this->db_user 		= "amerasek_db_pibtusername"; //Database user name
		$this->db_password 	= "656shfhfb"; //Database password
		$this->db_database 	= "amerasek_db_pibt"; //Database name

		//Connect to the database using MYSQLI
		$this->db_con = new MySQLi($this->db_hostname,$this->db_user,$this->db_password,$this->db_database);
 
    	//Check if there is connection error
		if ($this->db_con->connect_errno) {
		 die("ERROR : -> ".$this->db_con->connect_error);
		}
	}

	/**
	* Check username or password exists
	*
	* @param String $column_name name of column Eg: Email or Password
	* @param String $value value of column
	* @return function will return number of rows of relevant result 
	*/
	public function checkUsernameOrPassword($column_name,$value)
	{

		$check_email = $this->db_con->query("SELECT User_Name FROM view_get_all_users WHERE $column_name='$value' AND Active=1");
 		$count=$check_email->num_rows;

 		return $count;
	}

	/**
	* Get student details by student id
	*
	* @param Integer $id student id
	* @return Function will return all details of relevant student 
	*/
	public function getStudentDetailsById($id)
	{
		$query = $this->db_con->query("SELECT * FROM students WHERE Student_Id='$id'");
 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Get all student details
	*
	* @return Function will return all Students details 
	*/
	public function getStudentDetails()
	{
		$query = $this->db_con->query("SELECT * FROM students ORDER BY Student_Id DESC");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	/**
	* Get student details by student user name
	*
	* @param String $user_name username of student
	* @return Function will return student details by username 
	*/
	/*public function checkStudentUserName($user_name)
	{
		$query = $this->db_con->query("SELECT * FROM students WHERE User_Name='".$user_name."'");
 		$result=$query->fetch_array();

 		return $result;
	}*/

	/**
	* Get student details by student email
	*
	* @param String $email email of student
	* @return Function will return student details by student email 
	*/
	/*public function checkStudentEmail($email)
	{
		$query = $this->db_con->query("SELECT * FROM students WHERE Email='".$email."'");
 		$result=$query->fetch_array();

 		return $result;
	}*/

	/**
	* Get user details by user email and password
	*
	* @param String $password Password of user
	* @param String $user_name username of user
	* @return Function will return active user details by email and password 
	*/
	public function getUserDetails($password,$user_name)
	{
		$query = $this->db_con->query("SELECT * FROM view_get_all_users WHERE User_Name='$user_name' AND Password='$password' AND Active=1");

 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Save student details
	*
	* @param String $f_name First name of student
	* @param String $l_name Last name of student
	* @param String $email Email of student
	* @param String $password Password of student
	* @param Integer $active Active status
	* @param String $user_name Username of student
	* @param Integer $dep_id department id
	* @param String $image profile photo of student
	* @return Function will return NULL if query fails | return student id if query success 
	*/
	public function insertStudentDetails($f_name,$l_name,$email,$password,$active,$user_name,$dep_id,$image)
	{
		$today = date("Y-m-d H:i:s");
		$query = $this->db_con->query("INSERT INTO `students`(`F_Name`, `L_Name`, `Email`, `Password`, `Active`, `User_Name`, `Dep_Id`, `Image`) VALUES ('".$f_name."','".$l_name."','".$email."','".md5($password)."','".$active."','".$user_name."','".$dep_id."','".$image."')");

 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	/**
	* Update student details by relevant student
	*
	* @param String $f_name First name of student
	* @param String $l_name Last name of student
	* @param String $password Password of student
	* @param Integer $dep_id department id
	* @param String $image profile photo of student
	* @param Integer $id student id
	* @return Function will return NULL if query success
	*/
	public function updateStudentDetails($f_name,$l_name,$password,$dep_id,$image,$id)
	{
		$password_parms = '';
		if ($password != '') {
			$password_parms = ",`Password`='".md5($password)."'";
		}

		$image_parms = '';
		if ($image != '') {
			$image_parms = ",`Image`='".$image."'";
		}

		$query = $this->db_con->query("UPDATE `students` SET `F_Name`='".$f_name."',`L_Name`='".$l_name."',`Dep_Id`='".$dep_id."' ".$password_parms." ".$image_parms." WHERE Student_Id = '".$id."'");
 		return $query;
	}

	/**
	* Get staff user details by staff id
	*
	* @param Integer $id staff id
	* @return Function will return all details of relevant staff user 
	*/
	public function getStaffDetailsById($id)
	{
		$query = $this->db_con->query("SELECT * FROM staff WHERE Staff_Id='$id'");
 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Get all staff user details
	*
	* @return Function will return all Staff user details 
	*/
	public function getStaffDetails()
	{
		$query = $this->db_con->query("SELECT * FROM staff ORDER BY Staff_Id DESC");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	/**
	* Get staff details by staff user name
	*
	* @param String $user_name username of staff user
	* @return Function will return staff user details by username 
	*/
	/*public function checkStaffUserName($user_name)
	{
		$query = $this->db_con->query("SELECT * FROM staff WHERE User_Name='".$user_name."'");
 		$result=$query->fetch_array();

 		return $result;
	}*/

	/**
	* Get staff details by staff email
	*
	* @param String $email email of staff
	* @return Function will return staff details by staff email 
	*/
	/*public function checkStaffEmail($email)
	{
		$query = $this->db_con->query("SELECT * FROM staff WHERE Email='".$email."'");
 		$result=$query->fetch_array();

 		return $result;
	}*/

	/**
	* Get all QA Coordinator details by Department id
	*
	* @param Integer $department Department id
	* @return Function will return all QA Coordinator details by Department id
	*/
	public function getQACoordinatorByDepartment($department)
	{
		$query = $this->db_con->query("SELECT * FROM staff WHERE User_Role_Id = '4' AND Dep_Id = '".$department."'");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Save staff details
	*
	* @param String $user_name Username of staff
	* @param String $email Email of staff
	* @param Integer $active Active status
	* @param String $f_name First name of staff
	* @param String $l_name Last name of staff
	* @param String $password Password of staff
	* @param Integer $user_role_id Role id of staff
	* @param Integer $dep_id department id
	* @param String $image profile photo of staff
	* @return Function will return NULL if query fails | return staff id if query success 
	*/
	public function insertStaffDetails($user_name,$email,$active,$f_name,$l_name,$password,$user_role_id,$dep_id,$image)
	{
		if ($dep_id == '') {
			$query = $this->db_con->query("INSERT INTO `staff`(`User_Name`, `Email`, `Active`, `F_Name`, `L_Name`, `Password`, `User_Role_Id`, `Dep_Id`, `Image`) VALUES ('".$user_name."','".$email."','".$active."','".$f_name."','".$l_name."','".md5($password)."','".$user_role_id."',NULL,'".$image."')");	
		}else{
			$query = $this->db_con->query("INSERT INTO `staff`(`User_Name`, `Email`, `Active`, `F_Name`, `L_Name`, `Password`, `User_Role_Id`, `Dep_Id`, `Image`) VALUES ('".$user_name."','".$email."','".$active."','".$f_name."','".$l_name."','".md5($password)."','".$user_role_id."','".$dep_id."','".$image."')");
		}
		

 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	/**
	* Update staff details by relevant staff
	*
	* @param String $f_name First name of staff
	* @param String $l_name Last name of staff
	* @param String $password Password of staff
	* @param Integer $dep_id department id
	* @param String $image profile photo of staff
	* @param Integer $user_role_id Role id of staff
	* @param Integer $id staff id
	* @return Function will return NULL if query success
	*/
	public function updateStaffDetails($f_name,$l_name,$password,$dep_id,$image,$user_role_id,$id)
	{
		$password_parms = '';
		if ($password != '') {
			$password_parms = ",`Password`='".md5($password)."'";
		}

		$image_parms = '';
		if ($image != '') {
			$image_parms = ",`Image`='".md5($image)."'";
		}

		$query = $this->db_con->query("UPDATE `staff` SET `F_Name`='".$f_name."',`L_Name`='".$l_name."',`Dep_Id`='".$dep_id."' ".$password_parms." ".$image_parms." WHERE Student_Id = '".$id."'");

 		return $query;
	}

	/**
	* Get department details by department id
	*
	* @param Integer $id Department id
	* @return Function will return department details of relevant department id
	*/
	public function getDepartmentDetailsById($id)
	{
		$query = $this->db_con->query("SELECT Name,Acadamic_Y_Id FROM departments WHERE Dep_Id='".$id."'");
		$result=$query->fetch_array();
 		return $result;
	}

	/**
	* Get all departments details
	*
	* @return Function will return all departments details
	*/
	public function getDepartment()
	{
		$query = $this->db_con->query("SELECT * FROM departments");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get category details by category id
	*
	* @param Integer $id Category id
	* @return Function will return Category details of relevant Category id
	*/
	public function getCategoryById($id)
	{
		$query = $this->db_con->query("SELECT * FROM categories WHERE Category_Id='".$id."'");
 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Get all category details
	*
	* @return Function will return all category details
	*/
	public function getCatgeoryDetails()
	{
		$query = $this->db_con->query("SELECT * FROM categories");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Save category details
	*
	* @param String $name Category name
	* @return Function will return NULL if query fails | return saved category id if query success 
	*/
	public function insertCategoryDetails($name)
	{
		$query = $this->db_con->query("INSERT INTO `categories`(`Name`) VALUES ('".$name."')");

 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	/**
	* Update category details by relevant category
	*
	* @param String $name category name 
	* @param Integer $id category id
	* @return Function will return NULL if query success
	*/
	public function updateCategoryDetails($name,$id)
	{
		$query = $this->db_con->query("UPDATE `categories` SET `Name`='".$name."' WHERE Category_Id = '".$id."'");
 		return $query;
	}

	/**
	* Get all ideas by per page
	*
	* @param Integer $offset offset 
	* @param Integer $limit Per page limit
	* @return Function will return all ideas by per page
	*/
	public function getIdeaList($offset, $limit)
	{
		$query = $this->db_con->query("SELECT * FROM `ideas` ORDER BY Added_Date DESC limit $offset, $limit");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get all ideas
	*
	*/
	public function getIdeaListView()
	{
		$query = $this->db_con->query("SELECT * FROM `view_get_all_ideas` ORDER BY Added_Date DESC");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get all Anonymous ideas by per page
	*
	* @param Integer $offset offset 
	* @param Integer $limit Per page limit
	* @return Function will return all Anonymous ideas by per page
	*/
	public function getAnonymousIdeaList($offset, $limit)
	{
		$query = $this->db_con->query("SELECT * FROM `ideas` WHERE Anonymous_Status = 1 ORDER BY Added_Date DESC limit $offset, $limit");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get idea details by idea id
	*
	* @param Integer $id idea id 
	* @return Function will return idea details by idea id
	*/
	public function getIdeaById($id)
	{
		$query = $this->db_con->query("SELECT * FROM `ideas` WHERE Idea_Id = '".$id."'");
 		$result=$query->fetch_array();
 		return $result;
	}

	/**
	* Get total number of ideas
	*
	* @return Function will return total number of ideas
	*/
	public function getIdeaListCount()
	{
		$query = $this->db_con->query("SELECT COUNT(*) as 'total_rows' FROM `ideas`");
 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Get total number of Anonymous ideas
	*
	* @return Function will return total number of Anonymous ideas
	*/ 
	public function getAnonymousIdeaListCount()
	{
		$query = $this->db_con->query("SELECT COUNT(*) as 'total_rows' FROM `ideas` WHERE Anonymous_Status = 1");
 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Get most viewd ideas
	*
	* @param Integer $limit limit of ideas
	* @return Function will return list of most viewd ideas
	*/
	public function getMostViewdIdeas($limit = null)
	{
		$query_limit = '';
		if ($limit) {
			$query_limit = 'LIMIT '.$limit;
		}

		$query = $this->db_con->query("SELECT * FROM ideas WHERE Idea_View_count != 0 ORDER BY Idea_View_count DESC  ".$query_limit);
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Save idea details
	*
	* @param String $topic topic of idea
	* @param String $description description of idea
	* @param Integer $anonymous_status anonymous status | if it is a anonymous idea then $anonymous_status should * 	   be 1
	* @param String $file file name of idea
	* @param Integer $user_id student id
	* @param Integer $category_id category id
	* @param Integer $acadamic_y_id acadamic year id
	* @return Function will returns NULL if query fails | returns, saved idea id if query success 
	*/
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

	/**
	* Saved view count of idea
	*
	* @param Integer $idea_id idea id
	* @return Function will returns NULL if query success
	*/
	public function addViewCountToIdea($idea_id)
	{
		$query = $this->db_con->query("UPDATE `ideas` SET `Idea_View_count`=Idea_View_count+1 WHERE `Idea_Id`='".$idea_id."'");

 		return $query;
	}

	/**
	* Get all comments by per page
	*
	* @param Integer $offset offset 
	* @param Integer $limit Per page limit
	* @return Function will return all comments by per page
	*/
	public function getCommentsList($offset, $limit)
	{
		$query = $this->db_con->query("SELECT * FROM `comments` ORDER BY Added_Date DESC limit $offset, $limit");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get total number of comments
	*
	* @return Function will return total number of comments
	*/
	public function getCommentsCount()
	{
		$query = $this->db_con->query("SELECT COUNT(*) as 'total_rows' FROM `comments`");
 		$result=$query->fetch_array();

 		return $result;
	}

	/**
	* Get all Anonymous comments by per page
	*
	* @param Integer $offset offset 
	* @param Integer $limit Per page limit
	* @return Function will return all Anonymous comments by per page
	*/
	public function getAnonymousCommentsList($offset, $limit)
	{
		$query = $this->db_con->query("SELECT * FROM `comments` WHERE Anonymous_Status = 1 ORDER BY Added_Date DESC limit $offset, $limit");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get total number of Anonymous comments
	*
	* @return Function will return total number of Anonymous comments
	*/
	public function getAnonymousCommentsCount()
	{
		$query = $this->db_con->query("SELECT COUNT(*) as 'total_rows' FROM `comments` WHERE Anonymous_Status = 1");
 		$result=$query->fetch_array();
 		return $result;
	}

	/**
	* Get comments by idea and student or comments by idea
	*
	* @param Integer $idea_id idea id 
	* @param Integer $user_type user role id
	* @return Function will return all comments by idea and student or comments by idea
	*/
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

	/**
	* Get comments by idea id
	*
	* @param Integer $idea_id idea id 
	* @return Function will return comments details by idea
	*/
	public function getCommentsById($idea_id)
	{
		$query = $this->db_con->query("SELECT * FROM comments WHERE Idea_Id = '".$idea_id."' ORDER BY Added_Date DESC");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	/**
	* Save comment details
	*
	* @param Integer $user_id student id
	* @param Integer $idea_id idea id
	* @param Integer $user_type user role id
	* @param String $comment comment 
	* @param Integer $status anonymous status | if it is a anonymous comment then $status should be 1
	* @return Function will returns NULL if query fails | returns, saved comment id if query success 
	*/
	public function saveComment($user_id,$idea_id,$user_type,$comment,$status)
	{
		if ($user_type == 2) {
			$query = $this->db_con->query("INSERT INTO `comments`(`Comment_Description`, `Anonymous_Status`, `Idea_Id`, `Student_Id`,`Staff_Id`) VALUES ('".$comment."','".$status."','".$idea_id."','".$user_id."',NULL)");
		}else{
			$query = $this->db_con->query("INSERT INTO `comments`(`Comment_Description`, `Anonymous_Status`, `Idea_Id`, `Staff_Id`,`Student_Id`) VALUES ('".$comment."','".$status."','".$idea_id."','".$user_id."',NULL)");
		}

 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	/**
	* Get likes count or dislikes count by idea id 
	*
	* @param Integer $status Like or dislike | if it is a like then $status should be 1 | if it is a dislike the
	*		 $status should be 2
	* @param Integer $idea_id idea id  
	* @return Function will return likes count or dislikes count by idea id 
	*/
	public function getCountLikeDislikeById($status,$idea_id)
	{
		$query = $this->db_con->query("SELECT count(*) as count FROM likes_dislike WHERE Status = '".$status."' AND Idea_Id = '".$idea_id."'");
 		$result = $query->fetch_array();
 		return $result['count'];
	}

	/**
	* Get most popular ideas
	*
	* @param Integer $limit limit of ideas 
	* @return Function will return list of most popular ideas
	*/
	public function getMostPopularIdeas($limit = null)
	{

		$query_limit = '';
		if ($limit) {
			$query_limit = 'LIMIT '.$limit;
		}

		$query = $this->db_con->query("SELECT Idea_Id, sum(st_like) LIKECOUNT FROM( SELECT Idea_Id,case when status = 1 THEN Count(Status) ELSE -1 * count(Status) END st_like FROM likes_dislike GROUP BY Idea_Id,status ) A GROUP BY Idea_Id ORDER BY LIKECOUNT DESC ".$query_limit);
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	/**
	* Get likes, dislikes by user, idea and user role
	*
	* @param Integer $user_id user id | student or staff
	* @param Integer $idea_id idea id
	* @param Integer $user_type user role id
	* @return Function will return list of likes, dislikes by user, idea and user role
	*/
	public function getLikeDislikeIdeaByUser($user_id,$idea_id,$user_type)
	{
		$result = '';
		if ($user_type == 1) {
			$query = $this->db_con->query("SELECT Status FROM likes_dislike WHERE Student_Id = '".$user_id."' AND Idea_Id = '".$idea_id."'");
			if ($query) {
				$result = $query->fetch_array();
			}
			
		}else{
			$query = $this->db_con->query("SELECT Status FROM likes_dislike WHERE Staff_Id = '".$user_id."' AND Idea_Id = '".$idea_id."'");
			if ($query) {
				$result = $query->fetch_array();
			}

		}
 		return $result;
	}

	/**
	* Delete like and dislikes by user, idea and user role
	*
	* @param Integer $user_id user id | student or staff
	* @param Integer $idea_id idea id
	* @param Integer $user_type user role id
	* @return Function will return NULL if query success
	*/
	public function deleteLikeDislikeByIdeaUser($user_id,$idea_id,$user_type)
	{
		if ($user_type == 1) {
			$query = $this->db_con->query("DELETE FROM `likes_dislike` WHERE Student_Id = '".$user_id."' AND Idea_Id = '".$idea_id."'");
		}else{
			$query = $this->db_con->query("DELETE FROM `likes_dislike` WHERE Staff_Id = '".$user_id."' AND Idea_Id = '".$idea_id."'");
		}
		
 		return $query;
	}

	/**
	* Save like or dislike
	*
	* @param Integer $idea_id idea id
	* @param Integer $student_id student id
	* @param Integer $staff_id staff id
	* @param Integer $status like or dislike status | if it is like then $status should be 1 | if it is a dislike 
	*        then $status should be 2
	* @return Function will returns NULL if query fails | returns, saved id if query success 
	*/
	public function saveLikeDislike($idea_id,$student_id,$staff_id,$status)
	{
		if ($student_id == 0) {
			$query = $this->db_con->query("INSERT INTO `likes_dislike`(`Status`,`Idea_Id`, `Student_Id`, `Staff_Id`) VALUES ('".$status."','".$idea_id."',NULL,'".$staff_id."')");
		}else{
			$query = $this->db_con->query("INSERT INTO `likes_dislike`(`Status`,`Idea_Id`, `Student_Id`, `Staff_Id`) VALUES ('".$status."','".$idea_id."','".$student_id."',NULL)");
		}
	
 		if ($query) {
 			$result = $this->db_con->insert_id;
 		}else{
 			$result = '';
 		}

 		return $result;
	}

	/**
	* Get acadamic year details
	*
	* @return Function will return acadamic years details
	*/
	public function getAcadamicYear()
	{
		$query = $this->db_con->query("SELECT * FROM acadamic_year ORDER BY Active DESC");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}

 		return $result;
	}

	/**
	* Get acadamic year by acadamic year id
	*
	* @param Integer $id acadamic year id
	* @return Function will return acadamic year by acadamic year id
	*/
	public function getAcadamicYearById($id)
	{
		$query = $this->db_con->query("SELECT * FROM acadamic_year WHERE Acadamic_Y_Id = '".$id."'");
		$result = $query->fetch_array();
		
 		return $result;
	}

	/**
	* Update acadamic year by acadamic year id
	*
	* @param Integer $id acadamic year id
	* @param Integer $year Year
	* @param String $title title
	* @param Date $closure_date closure date
	* @param Date $final_closure_date final closure date
	* @param Integer $status Active status
	* @return Function will return NULL if query success
	*/
	public function updateAcadamicYear($id,$year,$title,$closure_date,$final_closure_date,$status)
	{
		if ($status == 1) {
			$query = $this->db_con->query("UPDATE `acadamic_year` SET `Active`='0'");
		}

		$query = $this->db_con->query("UPDATE `acadamic_year` SET `Year`='".$year."',`Title`='".$title."',`Final_Closure_Date`='".$final_closure_date."',`Closure_Date`='".$closure_date."',`Active`='".$status."' WHERE `Acadamic_Y_Id`='".$id."'");

 		return $query;
	}

	/**
	* Get all user role
	*
	* @return Function will return list of all user role
	*/
	public function getUserRoles()
	{
		$query = $this->db_con->query("SELECT * FROM user_roles");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	/**
	* Delete record
	*
	* @param String $table_name table name of deleting record
	* @param String $column_name column name
	* @param Integer $value deleting record id
	* @return Function will return NULL if query success
	*/
	public function deleteRecord($table_name,$column_name,$value)
	{
		$query = $this->db_con->query("DELETE FROM $table_name WHERE $column_name = '".$value."'");
 		return $query;
	}

	/**
	* Get number of idea each department
	*
	* @return Function will return list of number of idea each department
	*/
	public function getNumberOfIdeaForDepartment()
	{
		$query = $this->db_con->query("SELECT * FROM view_numer_of_idea_for_department");
 		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
 		return $result;
	}

	/**
	* Get Number of contributors within each Department.
	*
	* @return Function will return list of Number of contributors within each Department.
	*/
	public function getNumberOfContributorsForDepartment()
	{
		$query = $this->db_con->query("CALL contributors_for_department(1)");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
		mysqli_next_result($this->db_con);
 		return $result;
	}

	/**
	* Get Ideas without a comment
	*
	* @return Function will return list of Ideas without a comment
	*/
	public function ideaWithoutAComment()
	{
		$query = $this->db_con->query("CALL idea_without_comment(1)");
		$result = array();
 		while ($row=$query->fetch_assoc()){
 			$result[] = $row;
 		}
		mysqli_next_result($this->db_con);
 		return $result;
	}

	///////////////////////////////////////////////////////////////////////////////////////////

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
		    $string .= '... <a onclick="viewPage('.$id.')" class="a_tag2">Read More</a>';
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