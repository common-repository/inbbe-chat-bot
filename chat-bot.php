<?php
/*
Plugin Name: Inbbe Chat Bot
Plugin URI: https://inbbelab.com/
Description: Help yourself with a virtual agent for your everyday or business petitions.
Version: 1.0
Author: Inbbe
Author URI: https://inbbelab.com/

*/
if ( ! defined( 'ABSPATH' ) ) exit; 


define('INBBE_PATH',plugin_dir_path(__FILE__));
define('INBBE_URL',plugin_dir_url(__FILE__));
define('INBBE_NAME','Inbbe');


include(INBBE_PATH.'/includes/options.php');

function INBBECHATBOTprinthtml(){

    echo '
<div class="INBBE-CHATBOT-chat-inbbe-container" >
    <div class="INBBE-CHATBOT-container-top" id="INBBE-CHATBOT-container-top">
    		<div class="INBBE-CHATBOT-containter-msg">
    			<!--msg-->
    			<div class="INBBE-CHATBOT-msg-header">
    				<div class="INBBE-CHATBOT-msg-header-img">
    					<img class="INBBE-CHATBOT-img-msg" src="'.esc_attr($_SESSION["INBBE_CHATBOT_web"]['image']).'" width="40" height="40"><!-- Imagen del usuario-->
    				</div>
    				<div class="INBBE-CHATBOT-active">
    					<h4>'.esc_attr($_SESSION["INBBE_CHATBOT_web"]['name'])." ".esc_attr($_SESSION["INBBE_CHATBOT_web"]['lastname']).'</h4>
    					<!--<h6>última conexión</h6>-->
    				</div>
    
    				<!--<div class="INBBE-CHATBOT-header-icons">
    					<i class="fa fa-phone"></i>
    					<i class="fa fa-video-camera"></i>
    					<i class="fa fa-info-circle"></i>
    				</div>-->
    				<div onclick="INBBE_CHATBOT_display_chat()"><i class="fa fa-times" style="color:white"></i></div>
    			</div>
    			<div class="INBBE-CHATBOT-chat-page" id="INBBE-CHATBOT-chat-page">
    				<div class="INBBE-CHATBOT-msg-inbox">
    				<div class="INBBE-CHATBOT-chats">
    				<div class="INBBE-CHATBOT-msg-page" id="INBBE-CHATBOT-msg-page">

    				</div>
    				</div>
    				</div>	
    
    				<div class="INBBE-CHATBOT-msg-bottom">
    					
    					<div class="INBBE-CHATBOT-bottom-icons">
    					    <a id="INBBE-CHATBOT-inbbe-link" href="https://inbbelab.com"> By Inbbe </a>
        					<!--
        						<i class="fa fa-plus-circle"></i>
        						<i class="fa fa-camera"></i>
        						<i class="fa fa-microphone"></i>
        						<i class="fa fa-smile-o"></i>
        					-->
    					</div>
    					<div class="INBBE-CHATBOT-input-group">
    						<input type="text" class="form-control" id="INBBE-CHATBOT-text-input" placeholder="write message...">
    						<div class="INBBE-CHATBOT-input-group-append">
    						    
    							<span class="INBBE-CHATBOT-input-group-text"> <!--onclick="INBBE_CHATBOT_send_message()">-->
    							    <div class="form-submit">
        							    <div class="submit button INBBE-CHATBOT-as-read">
        							        <i id="INBBE-CHATBOT-icon-send" class="fa fa-paper-plane"></i>
        							    </div>
    							    </div>
    						    </span>
    							    
    							    
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    <div id="INBBE-CHATBOT-start">
    	<div id="INBBE-CHATBOT-chat-bot" onclick="INBBE_CHATBOT_display_chat()">
    		<!--<nav>
    			<ul>
    				<h3 onclick="INBBE_CHATBOT_display_chat()">Chat Bot</h3>
    			</ul>
    		</nav>-->
    	</div>
    </div>
</div>
';
}


function INBBECHATBOTjquery(){
    wp_enqueue_script( 'jquery');
}
function INBBECHATBOTprinthead(){
    wp_enqueue_style( 'main-styles', INBBE_URL.'css/style.css');
    wp_enqueue_script( 'main-scripts', INBBE_URL.'js/script.js');

    wp_localize_script ( 'main-scripts' ,  'pw_script_vars' ,  array ( 
		    'ajaxurl' => admin_url('admin-ajax.php'),
		    'profile_img' =>  $_SESSION["INBBE_CHATBOT_web"]['image'],
		    'user_img' => INBBE_URL."/img/user.png",
		    'nonce' => wp_create_nonce()
		));
}

function INBBECHATBOTweb(){
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    }
    if(!isset($_SESSION["INBBE_CHATBOT_web"])){
        
        try{
            $gestor = fopen(INBBE_URL."admin/files/user.txt", "r");
            $line = fgets($gestor);
            $values = explode("__",$line);
            
            if($values[3] !=''&& $values[4] !=''){
                $_SESSION["INBBE_CHATBOT_web"]['name'] = $values[0]; 
                $_SESSION["INBBE_CHATBOT_web"]['lastname'] = $values[1]; 
                $_SESSION["INBBE_CHATBOT_web"]['username'] = $values[2];
                $_SESSION["INBBE_CHATBOT_web"]['image'] = $values[3];
                $_SESSION["INBBE_CHATBOT_web"]['password'] = $values[4];
                $_SESSION["INBBE_CHATBOT_web"]['tipoBot'] = $values[5];
                 
            }
            else{
                $_SESSION["INBBE_CHATBOT_web"]['name'] = 'Agente'; 
                $_SESSION["INBBE_CHATBOT_web"]['lastname'] = 'Virtual'; 
                $_SESSION["INBBE_CHATBOT_web"]['username'] = 'Inbbe';
                $_SESSION["INBBE_CHATBOT_web"]['image'] = INBBE_URL."/img/bot.png";
                $_SESSION["INBBE_CHATBOT_web"]['password']='$2b$12$pZzbDbM9tmOl9oI0uClQnOuAtMl5L605sVYeWWCx1HwAVc5XHJCZG';
                $_SESSION["INBBE_CHATBOT_web"]['tipoBot'] = '1';
                
            }
            $_SESSION["INBBE_CHATBOT_web"]["url"] = INBBE_URL;
           
    
            fclose($gestor);
            
            
            
        } catch(Exception $e) {
            
            $_SESSION["INBBE_CHATBOT_web"]['name'] = 'Agente'; 
            $_SESSION["INBBE_CHATBOT_web"]['lastname'] = 'Virtual'; 
            $_SESSION["INBBE_CHATBOT_web"]['username'] = 'Inbbe';
            $_SESSION["INBBE_CHATBOT_web"]['image'] = INBBE_URL."/img/bot.png";
            $_SESSION["INBBE_CHATBOT_web"]['password']='$2b$12$pZzbDbM9tmOl9oI0uClQnOuAtMl5L605sVYeWWCx1HwAVc5XHJCZG';
            $_SESSION["INBBE_CHATBOT_web"]['tipoBot'] = '1';
            
            $_SESSION["INBBE_CHATBOT_web"]["url"] = INBBE_URL;
            echo 'Capturada';
        }
        
    }
    else{
        
        try{
            $gestor = fopen(INBBE_PATH."admin/files/user.txt", "r");
            $line = fgets($gestor);
            $values = explode("__",$line);
            
            if($values[3] !=''&& $values[4] !=''){
                $_SESSION["INBBE_CHATBOT_web"]['name'] = $values[0]; 
                $_SESSION["INBBE_CHATBOT_web"]['lastname'] = $values[1]; 
                $_SESSION["INBBE_CHATBOT_web"]['username'] = $values[2];
                $_SESSION["INBBE_CHATBOT_web"]['image'] = $values[3];
                $_SESSION["INBBE_CHATBOT_web"]['password'] = $values[4];
                $_SESSION["INBBE_CHATBOT_web"]['tipoBot'] = $values[5];
            }
            else{
                $_SESSION["INBBE_CHATBOT_web"]['name'] = 'Agente'; 
                $_SESSION["INBBE_CHATBOT_web"]['lastname'] = 'Virtual'; 
                $_SESSION["INBBE_CHATBOT_web"]['username'] = 'Inbbe';
                $_SESSION["INBBE_CHATBOT_web"]['image'] = INBBE_URL."/img/bot.png";
                $_SESSION["INBBE_CHATBOT_web"]['password']='$2b$12$pZzbDbM9tmOl9oI0uClQnOuAtMl5L605sVYeWWCx1HwAVc5XHJCZG';
                $_SESSION["INBBE_CHATBOT_web"]['tipoBot'] = '1';
                
            }
            $_SESSION["INBBE_CHATBOT_web"]["url"] = INBBE_URL;
            
            
            
        } catch(Exception $e) {
            
            $_SESSION["INBBE_CHATBOT_web"]['name'] = 'Agente'; 
            $_SESSION["INBBE_CHATBOT_web"]['lastname'] = 'Virtual'; 
            $_SESSION["INBBE_CHATBOT_web"]['username'] = 'Inbbe';
            $_SESSION["INBBE_CHATBOT_web"]['image'] = INBBE_URL."/img/bot.png";
            $_SESSION["INBBE_CHATBOT_web"]['password']='$2b$12$pZzbDbM9tmOl9oI0uClQnOuAtMl5L605sVYeWWCx1HwAVc5XHJCZG';
            $_SESSION["INBBE_CHATBOT_web"]['tipoBot'] = '1';
            $_SESSION["INBBE_CHATBOT_web"]["url"] = INBBE_URL;
            //echo 'Error registro user: ',  $e->getMessage(), "\n";
            echo 'Capturada';
        
        }
    
    }
}

function INBBECHATBOTchatbotcall(){
        $message = sanitize_text_field($_REQUEST["message"]);
        $message = esc_attr($message);
        
        $nonce = $_REQUEST["nonce"];
        if ( ! wp_verify_nonce( $nonce) )
            die ( 'Busted!!');
            
        
        $password = $_SESSION["INBBE_CHATBOT_web"]['password'];
        $bot = $_SESSION["INBBE_CHATBOT_web"]['tipoBot'];
        $ip ="83.34.59.245";
        $response = wp_remote_get( "https://inbbelab.cloud/polls/form_resp_bot/id=2&message=".$message."&ip=".$ip."&pwd=".$password."&bot=".$bot );
        echo  $response["body"];
    }
    
function INBBECHATBOTmessageasread() {
    
    do_action('inbbe_chatbot_call');
    wp_send_json_success(['Success!']);
    wp_send_json_error(['Error!']);
}



add_action('inbbe_chatbot_web','INBBECHATBOTweb');
do_action('inbbe_chatbot_web');

add_action('inbbe_chatbot_jquery','INBBECHATBOTjquery');
do_action('inbbe_chatbot_jquery');

add_action('wp_ajax_INBBECHATBOTmessageasread', 'INBBECHATBOTmessageasread');
add_action('wp_ajax_nopriv_INBBECHATBOTmessageasread', 'INBBECHATBOTmessageasread');    


add_action('inbbe_chatbot_call', 'INBBECHATBOTchatbotcall');

add_action( 'wp_footer','INBBECHATBOTprinthtml', 10,2);
add_action( 'wp_head', 'INBBECHATBOTprinthead');

function INBBECHATBOTlogin(){

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $nonce = $_POST["nonce"];
    if ( ! wp_verify_nonce( $nonce) )
        die ( 'Busted!!');
        
    $password = sanitize_text_field($_REQUEST["password"]);

    
    $json = wp_remote_get("https://inbbelab.cloud/polls/wp-login/".$password);
    //$data = json_decode($json); 
    $data = $json["body"];
    $data = json_decode($data);
    
    $_SESSION["INBBE_CHATBOT_user"]['name'] = $data->name; 
    $_SESSION["INBBE_CHATBOT_user"]['lastname'] = $data->lastname; 
    $_SESSION["INBBE_CHATBOT_user"]['username'] = $data->username;
    $_SESSION["INBBE_CHATBOT_user"]['image'] = $data->image;
    $_SESSION["INBBE_CHATBOT_user"]['tipoBot'] = $data->tipoBot;
    
    try{
        
        $file_data = $data->name."__".$data->lastname."__".$data->username."__".$data->image."__".$password."__".$data->tipoBot;
        
        $gestor = fopen(INBBE_PATH."/admin/files/user.txt", "w");
        fwrite($gestor, $file_data);
        fclose($gestor);
    } catch(Exception $e){
        echo '<script>console.log(Error: '.$e.')</script>';
    }
    echo  $_SESSION["INBBE_CHATBOT_user"]['name'];
}

function INBBECHATBOTlogout(){
   
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $nonce = $_POST["nonce"];
    if ( ! wp_verify_nonce( $nonce) )
        die ( 'Busted!!');
        
    unset($_SESSION["INBBE_CHATBOT_user"]);
    unset($_SESSION["INBBE_CHATBOT_web"]);
    $gestor = fopen(INBBE_PATH."/admin/files/user.txt", "w");
    fwrite($gestor, '');
    fclose($gestor);
    
    //session_destroy();
}

function inbbechatbotadminlogin() {
    
    do_action('inbbe_chatbot_login');
    wp_send_json_success(['Success!']);
    wp_send_json_error(['Error!']);
}

function inbbechatbotadminlogout(){
    
    do_action('inbbe_chatbot_logout');
    wp_send_json_success(['Success!']);
    wp_send_json_error(['Error!']);
}


add_action('wp_ajax_INBBECHATBOTadminlogin', 'INBBECHATBOTadminlogin');
add_action('wp_ajax_nopriv_INBBECHATBOTadminlogin', 'INBBECHATBOTadminlogin');  

add_action('wp_ajax_INBBECHATBOTadminlogout', 'INBBECHATBOTadminlogout');
add_action('wp_ajax_nopriv_INBBECHATBOTadminlogout', 'INBBECHATBOTadminlogout');  


add_action('inbbe_chatbot_login', 'INBBECHATBOTlogin');
add_action('inbbe_chatbot_logout', 'INBBECHATBOTlogout');

