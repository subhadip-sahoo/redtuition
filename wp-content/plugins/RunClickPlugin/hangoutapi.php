<?php header('Access-Control-Allow-Origin: *'); 

include('../../../wp-config.php');

require_once('Rest.inc.php');
error_reporting(0);
class HANGOUTAPI extends REST{
	
	

	/* Public function for access api. 

	   This function will call function automatically depends on query string */

	function processApi(){

		$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));

		if((int)method_exists($this,$func)>0){

			$this->$func();

		} else {

			$error = array('status' => "Failed", "msg" => "Invalid Access");

			$this->response($this->json($error), 404);	//This error is occured is function is not exist in the class

		}

	}



	/*

		getAccess function is used for checking is it registerd licence or not. If yes then you will get token_id

	*/

	function getAccess(){

		
		global $wpdb;
		// Cross validation if the request method is GET else it will return "Not Acceptable" status

		if(!$this->get_request_method()=='GET'){

			return $this->response('',406);

		}

		//$email = filter_var($this->_request['email'],FILTER_SANITIZE_EMAIL);

		//$key = filter_var($this->_request['key'],FILTER_SANITIZE_STRING);

		//$requesturl			=	get_option('umo_hangout_licenceurl');

		//Input validation


				//$datastring	=	"client_licence=$key&client_url=".site_url()."&email=$email";

				

				//$requesturl			.=	'wp-content/plugins/ghangout_main/licenc_test.php';



				

				

				//$result				=	umo_hangout_requestServer($requesturl,$datastring);

				

				//$result['result'] = (array) $result['result'];

				
					$token = md5(time());

					update_option('api_token',$token);
					
					$user_info = get_userdata(1);
					$msg = array("token_id" => $token, "admin_username" => $user_info->user_login, "admin_email" => $user_info->user_email );
					
					$this->setChatOperatorOnline();

					$this->response($this->json($msg), 200);	

		

	

	}
	
	
	/*

	* Get List of All Active User

	* Required parameter:- Token

	*/

	function getActiveUserList(){

		if(!$this->get_request_method()=='GET'){

			return $this->response('',406);

		}

		global $wpdb;

		$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

		if(!empty($token)){

			if(get_option('api_token')!=$token){

				$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

				$this->response($this->json($error),419);

			} else {
				//Jcasp
				$this->setChatOperatorOnline();
				$visitordata = $wpdb->get_results('select visitor_ID,name,email,last_activity,gravatar from '.$wpdb->prefix.'chat_online where visitor_ID!=0');

				if(sizeof($visitordata)>0){
				$result = array();

					foreach($visitordata as $vdata){

						$result[] = $vdata;

					}



					$this->response($this->json($result), 200);
				}
				else
				{
					$msg = array('status' => "Success", "msg" => "No User Record Found");

					$this->response($this->json(array()), 200);
				}

				

			

			}

		} else {

			$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

			$this->response($this->json($error),418);

		}

	}
	
	

	/*

	*	Required Parameter: Email, Token id

	*   Optional Parameter:  start, no_of_record

	*/

	function getUserChat(){

		global $wpdb;

		if(!$this->get_request_method()=='GET'){

			return $this->response('',406);

		}

		if(!empty($this->_request['token']) && !empty($this->_request['email'])){

		$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

		$email = filter_var($this->_request['email'],FILTER_SANITIZE_EMAIL);

		}

		if(!empty($token) && !empty($email)){

			if(get_option('api_token')!=$token){

				$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

				$this->response($this->json($error),419);

			} else {

				$userId = $wpdb->get_var(

							$wpdb->prepare(

											'select ID from '. $wpdb->prefix . 'chat_visitors WHERE email = %s',						$email

							)

				);

				if(!empty($userId)){



					$start = filter_var($this->_request['start'],FILTER_SANITIZE_NUMBER_INT);

					if(empty($start)) $start = 0;

					$limit = filter_var($this->_request['no_of_record'],FILTER_SANITIZE_NUMBER_INT);

					if(empty($limit)) $limit = 20;

					

					$chatdata = $wpdb->get_results(

						$wpdb->prepare(

							'Select * from '. $wpdb->prefix . 'chat_logs WHERE visitor_ID = %d order by chat_date desc limit %d,%d', $userId,$start,$limit 

						)

				);



				$result = array();
				//Jcasp
				asort($chatdata);
				
					$result['total_lines'] = count($chatdata);
					foreach($chatdata as $cdata){

						$chat[] = $cdata;

					}
					$result['chat'] = $chat;
					$this->response($this->json($result), 200);

				} else {

					$msg = array('status' => "Success", "msg" => "No User Found");

					$this->response($this->json($msg), 200);	

				}



			}

		} else {

			$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

			$this->response($this->json($error),418);

		}

	}

	

		/*

	*	Required Parameter: Email, Token id

	*   Optional Parameter:  start, no_of_record

	*/

	function getAllChat(){

		global $wpdb;

		if(!$this->get_request_method()=='GET'){

			return $this->response('',406);

		}

		if(!empty($this->_request['token'])){

		$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

		}

		if(!empty($token)){

			if(get_option('api_token')!=$token){

				$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

				$this->response($this->json($error),419);

			} else {





				$limit = filter_var($this->_request['no_of_record'],FILTER_SANITIZE_NUMBER_INT);

				if(empty($limit)) $limit = 20;
				
				$chatdata = $wpdb->get_results(

					$wpdb->prepare(

						'SELECT li.ID, ac.ID as log_id, ac.visitor_ID, li.chat_line  FROM '. $wpdb->prefix . 'chat_lines as li INNER JOIN '. $wpdb->prefix . 'chat_logs as ac ON li.chat_date= ac.chat_date where li.receiver_ID ="__OP__" and li.author IN (Select name from '. $wpdb->prefix . 'chat_online) ORDER BY li.ID DESC limit '.$limit

					)

				);

				//'Select * from '. $wpdb->prefix . 'chat_lines WHERE author IN (Select name from '. $wpdb->prefix . 'chat_online) AND receiver_ID ="__OP__" order by ID DESC limit '.$limit


				$result = array();

				$result['total_lines'] = count($chatdata);
				
				asort($chatdata);
				foreach($chatdata as $cdata){

					$chat[] = $cdata;

				}
				$result['chat'] = $chat;
				$this->response($this->json($result), 200);

			}

		} else {

			$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

			$this->response($this->json($error),418);

		}

	}

	
	
	/*

	* This function is used to add chat into db

	* If msg send by admin then sender will be username of 0 id and sender_email will be chat reciver email id. If it is not admin then it will be blank

	* Required Parameter:- token, visitor_id, sender, sender_email, chat_line, chat_date will be current timestamp

	*/

	function addChatMsg(){

		if(!$this->get_request_method()=='POST'){

			return $this->response('',406);

		}

		global $wpdb;

			$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

			if(!empty($token)){

				if(get_option('api_token')!=$token){

					$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

					$this->response($this->json($error),419);

				} else {

						$visitor_ID = filter_var($this->_request['visitor_id'],FILTER_SANITIZE_NUMBER_INT);

						$chat_date = filter_var(current_time( 'timestamp', 1 ),FILTER_SANITIZE_NUMBER_INT);

						$sender = filter_var($this->_request['sender'],FILTER_SANITIZE_STRING);

						$sender_email = filter_var($this->_request['sender_email'],FILTER_SANITIZE_EMAIL);

						$chat_line= filter_var($this->_request['chat_line'],FILTER_SANITIZE_STRING);	

						

						if(!empty($visitor_ID) && !empty($chat_date) && !empty($chat_line)){

							$wpdb->query(

									$wpdb->prepare(

										"insert into ".$wpdb->prefix."chat_logs(visitor_ID,chat_date,sender,sender_email,chat_line) values(%d,%d,%s,%s,%s)",$visitor_ID,$chat_date,$sender,$sender_email,$chat_line

									)	

							);

							 $id = $wpdb->insert_id;

							//$wpdb->query("select

							if($sender==''){

								

								$receiver = '__OP__';

								$vdata = $wpdb->get_results(

									$wpdb->prepare(

										"select name from ".$wpdb->prefix."chat_visitors where ID='%d'",$visitor_ID

									)	

								);

								

								$author = $vdata[0]->name;

								$gravatar = $wpdb->get_var(

									$wpdb->prepare(

										"select gravatar from ".$wpdb->prefix."chat_online where visitor_ID='0'"

									)	

								);	

									

									



							} else {



								$vdata = $wpdb->get_results(

									$wpdb->prepare(

										"select name from ".$wpdb->prefix."chat_online where visitor_ID='0'"

									)	

								);	

								$author = $vdata[0]->name;

								$vdata = $wpdb->get_results(

									$wpdb->prepare(

										"select name,gravatar from ".$wpdb->prefix."chat_visitors where ID='%d'",$visitor_ID

									)	

								);



								

								$receiver = $vdata[0]->name;

								$gravatar = $vdata[0]->gravatar;



							}

							$wpdb->query(

									$wpdb->prepare(

										"insert into ".$wpdb->prefix."chat_lines(author,gravatar,receiver_ID,chat_date,chat_line) values(%s,%s,%s,%s,%s)",$author,$gravatar,$receiver,$chat_date,$chat_line

									)	

							);



							$cid = $wpdb->insert_id;



							$success =  array('status'=>'success','id'=>$id);

							$this->response($this->json($success),200);	

						

						} else {

							$error =  array('status'=>'Failed','msg'=>'Invalid data');

							$this->response($this->json($error),418);		

						}

				}

			} else {

				$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

				$this->response($this->json($error),418);

			}

	}
	function checkit(){
			$postid=17;
			$file = WP_PLUGIN_DIR."/RunClickPlugin/ajax_for_pop_up.php"; 
			echo $current = file_get_contents($file);
			$printarr = json_decode($current);
			echo "<br>";
			
			$buyval ='push';
			foreach($printarr as $id => $key){
				$exitsid = $id;
				break;
			}
			if($exitsid == $postid){
				$curvote = $printarr->$exitsid->vote;
				$curbuy = $printarr->$exitsid->buy;
				if($buyval=='push'){
					$sarray[$postid]['vote'] = 'pull';
					$sarray[$postid]['buy'] = 'push';
				} else {
					$sarray[$postid]['vote'] = $curvote;
					$sarray[$postid]['buy'] = 'pull';
				}
			} else {
				$sarray[$postid]['vote'] = '';
				$sarray[$postid]['buy'] = $buyval;
			}
			$encode_data = json_encode($sarray);
			file_put_contents($file, $encode_data);
			
	}
	function pushbuyform() {
		global $wpdb;	
		if(!$this->get_request_method()=='POST'){
			return $this->response('',406);
		}
		$postid = filter_var($this->_request['postid'],FILTER_SANITIZE_NUMBER_INT);
		$buyval = filter_var($this->_request['buyval'],FILTER_SANITIZE_STRING);
		if($postid!=''){
			/*if($buyval=='push'){ update_post_meta($postid,'live_vote_form_push','pull');}
			update_post_meta($postid,'live_buy_form_push',$buyval);
			$livevote = get_post_meta($postid,'live_vote_form_push',true);
			$buy_form = get_post_meta($postid,'live_buy_form_push',true);*/
			
			
			$file = WP_PLUGIN_DIR."/RunClickPlugin/ajax_for_pop_up.php"; 
			$current = file_get_contents($file);
			$printarr = json_decode($current);
			
			
			
			foreach($printarr as $id => $key){
				$exitsid = $id;
				break;
			}
			if($exitsid == $postid){
				$curvote = $printarr->$exitsid->vote;
				$curbuy = $printarr->$exitsid->buy;
				if($buyval=='push'){
					$sarray[$postid]['vote'] = 'pull';
					$sarray[$postid]['buy'] = 'push';
				} else {
					$sarray[$postid]['vote'] = $curvote;
					$sarray[$postid]['buy'] = 'pull';
				}
			} else {
				$sarray[$postid]['vote'] = '';
				$sarray[$postid]['buy'] = $buyval;
			}
			$encode_data = json_encode($sarray);
			file_put_contents($file, $encode_data);
			
			
			$success =  array('status'=>'success','msg'=>$sarray[$postid]['vote'].' - '.$sarray[$postid]['buy']);
			$this->response($this->json($success),200);	
		}

	}
	
	function pushvoteform() {
		global $wpdb;	
		if(!$this->get_request_method()=='POST'){
			return $this->response('',406);
		}
		$postid = filter_var($this->_request['postid'],FILTER_SANITIZE_NUMBER_INT);
		$voteval = filter_var($this->_request['voteval'],FILTER_SANITIZE_STRING);
		if($postid!=''){
			/*update_post_meta($postid,'live_vote_form_push',$voteval);
			if($voteval=='push'){ update_post_meta($postid,'live_buy_form_push','pull');}
			$success =  array('status'=>'success','msg'=>'Push Vote Form Pushed Successfully');*/
			
			$file = WP_PLUGIN_DIR."/RunClickPlugin/ajax_for_pop_up.php"; 
			$current = file_get_contents($file);
			$printarr = json_decode($current);
			
			
			
			foreach($printarr as $id => $key){
				$exitsid = $id;
				break;
			}
			if($exitsid == $postid){
				$curvote = $printarr->$exitsid->vote;
				$curbuy = $printarr->$exitsid->buy;
				if($voteval=='push'){
					$sarray[$postid]['vote'] = 'push';
					$sarray[$postid]['buy'] = 'pull';
				} else {
					$sarray[$postid]['vote'] = 'pull';
					$sarray[$postid]['buy'] = $curbuy;
				}
			} else {
				$sarray[$postid]['vote'] = $curbuy;
				$sarray[$postid]['buy'] = '';
			}
			$encode_data = json_encode($sarray);
			file_put_contents($file, $encode_data);
			
			
			$success =  array('status'=>'success','msg'=>$sarray[$postid]['vote'].' - '.$sarray[$postid]['buy']);
			
			
			$this->response($this->json($success),200);	
		}

	
	}

	function logout() {
		global $wpdb;
		
			$wpdb->query(
				$wpdb->prepare(
					'DELETE FROM ' . $wpdb->prefix . 'chat_online WHERE visitor_ID = 0'
				)
			);
			
			$success =  array('status'=>'success','msg'=>'Logout');

			$this->response($this->json($success),200);
				
	}
	
	

	/*

	 * function to handle all curl requests

	*/

	private function umo_hangout_requestServer($serverurl,$datastring)

	{

			

			$ch		=	curl_init($serverurl);

			

			curl_setopt($ch,CURLOPT_POST,true);

			

			curl_setopt($ch,CURLOPT_POSTFIELDS,$datastring);

			

			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

			

			$output	=	curl_exec($ch);

			

			if($output === false)

			{

				curl_close($ch); 

				$response	=	"<response><update>0</update><version>0</version></response>";

				return $response;

			}

			else

			{

				curl_close($ch); //free system resources

	

				$response	=	simplexml_load_string($output);

				

				$response	=	(array) $response;

				

				return $response;

			}



			

	}



	/*

	 * function to get active tocken 

	*/

	function getActiveTocken(){

		$token = get_option('api_token');

		if(!empty($token)){

			$msg = array("token_id" => $token);

			$this->response($this->json($msg), 200);	

		} else {

			$error = array('status' => "Failed", "msg" => "No Active Tocken");

			$this->response($this->json($error), 503);	

		}

	}



	/*

	 * function to get all user details

	 * required fields : token, email

	*/

	function getUserDetails(){

		if(!$this->get_request_method()=='GET'){

			return $this->response('',406);

		}

		global $wpdb;

		

		//if(!empty($this->_request['token']) && !empty($this->_request['email'])){

		$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

		$email = filter_var($this->_request['email'],FILTER_SANITIZE_EMAIL);



		//}

		

		if(!empty($token) && !empty($email)){

			if(get_option('api_token')!=$token){

				$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

				$this->response($this->json($error),419);

			} else {

				$visitordata = $wpdb->get_results(

									$wpdb->prepare(

											'select ID,name,email,gravatar from '. $wpdb->prefix . 'chat_visitors WHERE email = %s',	$email

									)

								);



				if(sizeof($visitordata)>0){

				$result = array();

					foreach($visitordata as $vdata){

						$result[] = $vdata;

					}



					$this->response($this->json($result), 200);

				} else {

					$msg = array('status' => "Success", "msg" => "No User Record Found");

					$this->response($this->json($msg), 204);	

				}

			}

		} else {

			$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

			$this->response($this->json($error),418);

		}

	}

	

	







	/*

	* Get List of All User

	* Required parameter:- Token

	*/

	function getAllUserList(){

		if(!$this->get_request_method()=='GET'){

			return $this->response('',406);

		}

		global $wpdb;

		$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

		if(!empty($token)){

			if(get_option('api_token')!=$token){

				$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

				$this->response($this->json($error),419);

			} else {

				$visitordata = $wpdb->get_results(

							$wpdb->prepare('select ID,name,email,gravatar from '.$wpdb->prefix.'chat_visitors')

						);

				$result = array();

					foreach($visitordata as $vdata){

						$result[] = $vdata;

					}



					$this->response($this->json($result), 200);

				

			

			}

		} else {

			$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

			$this->response($this->json($error),418);

		}

	}





	function setChatOperatorOnline()
	{
		global $wpdb;
		$user_info = get_userdata(1);
		$gravatar = md5( strtolower( trim( $user_info->user_email) ) );
		$ip_address = sprintf( '%u', ip2long( g_hangout_get_IP() ) );
		
		$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."chat_online where email='".$user_info->user_email."'" );
		if($user_count == 0){
		$wpdb->insert( 
						$wpdb->prefix.'chat_online', 
						array( 
							'visitor_ID' 	=> 0,
							'name' 			=> $user_info->user_login,
							'email'			=> $user_info->user_email,
							'gravatar'		=> $gravatar,
							'type'			=> 1,
							'status'		=> 1,
							'ip_address'	=> $ip_address,
							'user_agent'	=> $_SERVER['HTTP_USER_AGENT'] 
						)
					);
		}	
	}

	function deletemsg(){

		if(!$this->get_request_method()=='DELETE'){

			return $this->response('',406);

		}



		global $wpdb;

		$token = filter_var($this->_request['token'],FILTER_SANITIZE_STRING);

		$msgid = filter_var($this->_request['msgid'],FILTER_SANITIZE_NUMBER_INT);

		if(!empty($token) && !empty($msgid)){

			if(get_option('api_token')!=$token){

				$error =  array('status'=>'Failed','msg'=>'Invalid Token Code');

				$this->response($this->json($error),419);

			} else {

					if($msgid > 0){		

						$wpdb->query(

								$wpdb->prepare(

									'delete from '.$wpdb->prefix.'chat_logs where ID=%d',$msgid	

								)

							);

							$success =  array('status'=>'success','msg'=>'Deleted');

							$this->response($this->json($success),200);	



					} else {

						$error =  array('status'=>'Failed','msg'=>'Invalid data');

						$this->response($this->json($error),418);

					}

			}

		} else {

				$error =  array('status'=>'Failed','msg'=>'Required Parameter Missing');

				$this->response($this->json($error),418);

		}



	}





	

	/*

	 *	Encode array into JSON

	*/

	private function json($data){

		if(is_array($data)){

			return json_encode($data);

		}

	}





}

	$api = new HANGOUTAPI;

	$api->processApi();



?>