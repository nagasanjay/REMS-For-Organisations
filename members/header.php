<?php
/*
* Header File
* For CMS For Organisations
*/
      // initialise
      session_start();  
      include("secrets_.php");      // Include Secret Keys such as APIs and override default database credentials
      
      // function to log
      // Call Example: logActivity($_SESSION['uname'], "Log Something"); 
      function logActivity($loggedOnUser, $log) {
            include("secrets_.php");
		$logActivityConn = new mysqli($servername, $username, $password, $dbname);
		if ($logActivityConn->connect_error) {
			die("Connection failed: " . $logActivityConn->connect_error);
		}
		$logSQL = 'CALL enterLog("' . $loggedOnUser . '","' . $log . '");';
		// echo $logSQL; // For Debugging
		if ($logActivityConn->query($logSQL) === TRUE) {
			// echo "Successfully Logged"; // For Debugging
		} else {
			// echo "Error: " . $logActivityConn->error; // For Debugging
			header('Location: '.$startPath.'/members/member-login.php');
		}
            $logActivityConn->close();
      }

      // returns 1 if user has admin privileges, else returns 0
      // Call Example: retIsAdmin($_SESSION['uname']); 
      function retIsAdmin($loggedOnUser) {
            include("secrets_.php");
            $retIsAdmin = new mysqli($servername, $username, $password, $dbname);
            if ($retIsAdmin->connect_error) {
                  die("Connection failed: " . $retIsAdmin->connect_error);
            }
            $retIsAdminSQL = 'select count(1) as code from login where LoginName="' . $loggedOnUser . '" and IsAdmin=1;';
            // echo $retIsAdminSQL; // For Debugging
            $Results  = $retIsAdmin->query($retIsAdminSQL);
            foreach ($Results as $row) {
                  return $row["code"];          
            }          
            $retIsAdmin->close();
      }


      // function to retieve profile pic
      // Call Example: retProfilePic($_SESSION['uname']); 
      function retProfilePic($loggedOnUser) {
            include("secrets_.php");
            $retProfilePic = new mysqli($servername, $username, $password, $dbname);
            if ($retProfilePic->connect_error) {
                  die("Connection failed: " . $retProfilePic->connect_error);
            }
            $retProfilePicSQL = 'select imgsrc from login where LoginName="' . $loggedOnUser . '" limit 1;';
            // echo $retProfilePicSQL; // For Debugging
            $logResults  = $retProfilePic->query($retProfilePicSQL);
            foreach ($logResults as $row) {
                  return $startPath . '/assets/img/avatars/users/' . $row["imgsrc"];          
            }          
            $retProfilePic->close();
      }


      
      // If Session doesn't exist
      if (!$_SESSION['uname']){
            header('Location: '.$startPath.'/members/member-login.php');    
      }
      else{
            if($_SESSION['remember']==0){
                  date_default_timezone_set('Asia/Kolkata');
                  $date1 = strtotime($_SESSION['loginTime']);
                  $date2 = strtotime(date('Y-m-d H:i:s'));
                  $secs = $date2 - $date1;// == <seconds between the two times>
                  $mins = $secs / 60;
                  // If inactive for 60 minuites
                  if($mins > 60){
                        session_destroy();
                        logActivity($_SESSION['uname'], 'Logged out due to inactivity');
                        header('Location: '.$startPath.'/members/member-login.php');
                  }
            }
            $loginUser = $_SESSION['uname'];
            $_SESSION['loginTime'] = date("Y-m-d H:i:s", time());
      }