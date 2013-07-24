<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Example
*
* This is an example of a few basic user interaction methods you could use
* all done with a hardcoded array.
*
* @package CodeIgniter
* @subpackage Rest Server
* @category Controller
* @author Phil Sturgeon
* @link http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/models/db_functions.php';

class Api extends REST_Controller
{
	function user_get()
	    {
	        /*
	    	if(!$this->get('id'))
	        {
	         $this->response(NULL, 400);
	        } 
			*/
	        // $user = $this->some_model->getSomething( $this->get('id') );
	        
	        // connect to DB
	        $con = connect_db('central_db');
	        
	        
	        //var_dump($this->get('status'));
	        
	        // define query
	        $query_string = "SELECT * FROM users WHERE username = '".$this->get('username')."'";
	        //var_dump($query_string);
	        // execute query
	        $result = $con->query($query_string);
	        //var_dump($result);
	        
	        // fetch results (one or none entry)
	        while ($row = $result->fetch_array())
	        {
	        	
	        	$id = intval($row['user_id']);
	        	
	        	$users[$id] = array(
						           'id' => $id,
						           'user_team' => intval($row['user_team']),
						           'name_user' => $row['name_user'],
						           'surname_user' => $row['surname_user'],
						           'username' => $row['username'],
						           'password' => $row['password'],
						           'email' => $row['email'],
						           'amka' => $row['amka'],
						           'status' => $row['status'],
						           'department' => $row['department']
	        					   
	        	);
	        	
	        }
	        
	        
	        // increase number of queries (tracking pusposes)
	        //$query_string = "TRUNCATE `stat_activity`;";
	        //$con->query($query_string);
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        // this array is the JSON root element
	        /*
		     $users = array(
				1 => array('id' => 1, 'name' => $username[1], 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
				2 => array('id' => 2, 'name' => $username[2], 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
				3 => array('id' => 3, 'name' => $username[3], 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('jogging', 'bikes'))),
			);
			*/
			
			

		    
		    
		     $user = @$users[$id];
	    
	        if($user)
	        {
	            $this->response($user, 200); // 200 being the HTTP response code
	        }
	
	        else
	        {
	            $this->response(array('error' => 'User could not be found'), 404);
	        }
	    }
	    
	    
	    
	    
	    function user_post()
	    {
	        
	    	
	    	$username = $this->get('username');
			$password = $this->post('password');
			$email = $this->post('email');
			$userteam = $this->post('user_team');
			$name = $this->post('name_user');
			$surname = $this->post('surname_user');
			$amka = $this->post('amka');
			$status = $this->post('status');
			$department = $this->post('department');
			
			
	    	
	    	$con = connect_db('central_db');
	    	// main query
	    	$query_string = "UPDATE `users` SET `password`='".$password."', `email`='".$email."', `user_team`='".$userteam."', `name_user`='".$name."', `surname_user`='".$surname."', `amka`='".$amka."', `status`='".$status."', `department`='".$department."' WHERE `username`='".$username."';";
	    	$con->query($query_string);
	    	
	        // increase queries (testing purposes)
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        //$this->response(array('message'=>'Updated'), 200); // 200 being the HTTP response code
	        
	        
	        // retreive updated
	        
	    	// define query
	        $query_string = "SELECT * FROM users WHERE username = '".$username."'";
	        //var_dump($query_string);
	        // execute query
	        $result = $con->query($query_string);
	        //var_dump($result);
	        
	        // fetch results (one or none entry)
	        while ($row = $result->fetch_array())
	        {
	        	
	        	$id = intval($row['user_id']);
	        	
	        	$users[$id] = array(
						           'id' => $id,
						           'user_team' => intval($row['user_team']),
						           'name_user' => $row['name_user'],
						           'surname_user' => $row['surname_user'],
						           'username' => $row['username'],
						           'password' => $row['password'],
						           'email' => $row['email'],
						           'amka' => $row['amka'],
						           'status' => $row['status'],
						           'department' => $row['department'],
	        						'message' => 'Updated'
	        					   
	        	);
	        	
	        }
	        
	        $this->response($users[$id], 200);
	        
	    }
	    
	    
	    
	    
	    
		function address_get()
	    {
	        /*
	    	if(!$this->get('id'))
	        {
	         $this->response(NULL, 400);
	        } 
			*/
	        // $user = $this->some_model->getSomething( $this->get('id') );
	        
	        // connect to DB
	        $con = connect_db('central_db');
	        
	        
	        //var_dump($this->get('status'));
	        
	        // define query
	        $query_string = "SELECT * FROM address AS a INNER JOIN users AS u ON a.user_id=u.user_id WHERE u.username = '".$this->get('username')."'";
	        //var_dump($query_string);
	        // execute query
	        $result = $con->query($query_string);
	        //var_dump($result);
	        
	        // fetch results (one or none entry)
	        while ($row = $result->fetch_array())
	        {
	        	
	        	$id = intval($row['user_id']);
	        	
	        	$address[$id] = array(
						           'id' => $id,
						           'nomos' => $row['nomos'],
						           'dimos' => $row['dimos'],
						           'city' => $row['city'],
						           'address' => $row['address'],
						           'postal_code' => $row['tk'],
						           'area' => $row['perioxi'],
						           'country' => $row['xwra']
	        					   
	        	);
	        	
	        }
	        
	        
	        // increase number of queries (tracking pusposes)
	        //$query_string = "TRUNCATE `stat_activity`;";
	        //$con->query($query_string);
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        // this array is the JSON root element
	        /*
		     $users = array(
				1 => array('id' => 1, 'name' => $username[1], 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
				2 => array('id' => 2, 'name' => $username[2], 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
				3 => array('id' => 3, 'name' => $username[3], 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('jogging', 'bikes'))),
			);
			*/
			
			

		    
		    
		     $addr = @$address[$id];
	    
	        if($addr)
	        {
	            $this->response($addr, 200); // 200 being the HTTP response code
	        }
	
	        else
	        {
	            $this->response(array('error' => 'User could not be found'), 404);
	        }
	    }
	    
	    
	    
	    
	    function address_post()
	    {
	        
	    	
	    	$username = $this->get('username');
			$nomos = $this->post('nomos');
			$dimos = $this->post('dimos');
			$city = $this->post('city');
			$address = $this->post('address');
			$postal_code = $this->post('postal_code');
			$area = $this->post('area');
			$country = $this->post('country');
			
	    	
			$con = connect_db('central_db');
			
			$query_string = "SELECT * FROM users WHERE username = '".$this->get('username')."'";
	    	$result = $con->query($query_string);
	    	
	    	$row = $result->fetch_array();
	    	$user_id = intval($row['user_id']);
			
	    	// main query
	    	$query_string  = "UPDATE `address` SET `nomos`='".$nomos."', `dimos`='".$dimos."', `city`='".$city."', `address`='".$address."',";
	    	$query_string .= " `tk`='".$postal_code."', `perioxi`='".$area."', `xwra`='".$country."' WHERE `user_id`='".$user_id."';";
	    	$con->query($query_string);
	    	
	        // increase queries (testing purposes)
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        $this->response(array('message'=>'Updated'), 200); // 200 being the HTTP response code
	    }
	    
	    
	    
	    
	    
	    
	    
	    
	    
		function phones_get()
	    {
	        
	        // connect to DB
	        $con = connect_db('central_db');
	        
	        
	        //var_dump($this->get('status'));
	        
	        // define query
	        $query_string = "SELECT * FROM phone_numbers AS p INNER JOIN users AS u ON p.user_id=u.user_id WHERE u.username = '".$this->get('username')."'";
	        //var_dump($query_string);
	        // execute query
	        $result = $con->query($query_string);
	        //var_dump($result);
	        
	        // fetch results (one or none entry)
	        while ($row = $result->fetch_array())
	        {
	        	
	        	$id = intval($row['user_id']);
	        	
	        	$phones[$id] = array(
						           'id' => $id,
						           'phone' => $row['telephone'],
						           'mobile' => $row['mobile'],
						           'fax' => $row['fax']
	        	);
	        	
	        }
	        
	        
	        // increase number of queries (tracking pusposes)
	        //$query_string = "TRUNCATE `stat_activity`;";
	        //$con->query($query_string);
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        // this array is the JSON root element
	        /*
		     $users = array(
				1 => array('id' => 1, 'name' => $username[1], 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
				2 => array('id' => 2, 'name' => $username[2], 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
				3 => array('id' => 3, 'name' => $username[3], 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('jogging', 'bikes'))),
			);
			*/
			
			

		    
		    
		     $ph = @$phones[$id];
	    
	        if($ph)
	        {
	            $this->response($ph, 200); // 200 being the HTTP response code
	        }
	
	        else
	        {
	            $this->response(array('error' => 'User could not be found'), 404);
	        }
	    }
	    
	    
	    
	    
	    
	    
	    function phones_post()
	    {
	        
	    	
	    	$username = $this->get('username');
			$phone = $this->post('phone');
			$mobile = $this->post('mobile');
			$fax = $this->post('fax');
			
	    	
			$con = connect_db('central_db');
			
			$query_string = "SELECT * FROM users WHERE username = '".$this->get('username')."'";
	    	$result = $con->query($query_string);
	    	
	    	$row = $result->fetch_array();
	    	$user_id = intval($row['user_id']);
			
	    	// main query
	    	$query_string  = "UPDATE `phone_numbers` SET `telephone`='".$phone."', `mobile`='".$mobile."', `fax`='".$fax."' WHERE `user_id`='".$user_id."';";
	    	$con->query($query_string);
	    	
	        // increase queries (testing purposes)
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        $this->response(array('message'=>'Updated'), 200); // 200 being the HTTP response code
	    } 
	    
	    
	    
	    
	    
	    
		function program_get()
	    {
	        /*
	    	if(!$this->get('id'))
	        {
	         $this->response(NULL, 400);
	        } 
			*/
	        // $user = $this->some_model->getSomething( $this->get('id') );
	        
	        // connect to DB
	        $con = connect_db('central_db');
	        
	        
	        //var_dump($this->get('status'));
	        
	        // define query
	        $query_string = "SELECT * FROM program AS p INNER JOIN users AS u ON p.user_id=u.user_id WHERE u.username = '".$this->get('username')."'";
	        //var_dump($query_string);
	        // execute query
	        $result = $con->query($query_string);
	        //var_dump($result);
	        
	        $prog = array();
	        
	        // fetch results (one or none entry)
	        while ($row = $result->fetch_array())
	        {
	        	
	        	$id = intval($row['program_id']);
	        	
	        	$program[$id] = array(
						           'id' => $id,
						           'date' => $row['date'],
						           'duty_type' => $row['duty_type'],
						           'duty_start_time' => $row['duty_start_time'],
						           'duty_end_time' => $row['duty_end_time'],
						           'location' => $row['location'],
						           'user_id' => intval($row['user_id']),
						           'program_name' => $row['program_name']
	        					   
	        	);
	        	
	        	$prog["programs"][] = @$program[$id];
	        	
	        }
	        
	        
	        // increase number of queries (tracking pusposes)
	        //$query_string = "TRUNCATE `stat_activity`;";
	        //$con->query($query_string);
	        $query_string = "UPDATE `stat_activity` SET `num_of_queries`=`num_of_queries`+1, `last_happened_on`=CURRENT_TIMESTAMP;";
	        $con->query($query_string);
	        
	        
	    
	        if($prog)
	        {
	            $this->response($prog, 200); // 200 being the HTTP response code
	        }
	
	        else
	        {
	            $this->response(array('error' => 'No program for this user.'), 404);
	        }
	    }
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    function users_get()
	    {
	        //$users = $this->some_model->getSomething( $this->get('limit') );
	        $users = array(
				array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
				array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
				3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
			);
	        
	        if($users)
	        {
	            $this->response($users, 200); // 200 being the HTTP response code
	        }
	
	        else
	        {
	            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
	        }
	    }
	
	
		public function send_post()
		{
			var_dump($this->request->body);
		}
		
		
		public function send_put()
		{
			var_dump($this->put('foo'));
		}
		
}