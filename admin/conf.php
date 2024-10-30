<?php
if ( ! defined( 'ABSPATH' ) ) exit; 



define('INBBE_URL',plugin_dir_url(__FILE__));


function INBBECHATBOTenqueueadminscript() {
    
    wp_enqueue_script( 'inbbe_chatbot_script', plugin_dir_url( __FILE__ ) . 'js/script.js', array(), '1.0' );
    wp_enqueue_script( 'jquery');
    wp_localize_script ( 'inbbe_chatbot_script' ,  'pw_script_admin_vars' ,  array ( 
		    'ajaxurl' => admin_url('admin-ajax.php'),
		    'nonce' => wp_create_nonce(),
		));
}


function INBBECHATBOTadminhead(){
    wp_enqueue_style( 'main-styles', INBBE_URL.'css/style.css');
    
   
    
}



add_action( 'wp_head', 'INBBECHATBOTadminhead');
add_action( 'admin_enqueue_scripts', 'INBBECHATBOTenqueueadminscript');

do_action( 'admin_enqueue_scripts' );



if (! current_user_can ('manage_options')) wp_die (__ ('You do not have enough permissions to access this page.'));
$nonce = wp_create_nonce();
?>
    <input type="hidden" id="INBBE-CHATBOT-nonce" value="<?php echo $nonce; ?>">
    <input type="hidden" id="INBBE-CHATBOT-path" value="<?php echo INBBE_URL; ?>">
	<div class="wrap">
	    
		<h2><?php _e( 'Inbbe', 'inbbe' ) ?></h2>
		Welcome to Inbbe configuration
	</div>
	<div id="admin-session">
	<?php 
	    echo $_SESSION["INBBE_CHATBOT_user"];
	    if(!isset($_SESSION["INBBE_CHATBOT_user"])){
	        ?> 
	       <div id="admin-session-login">
    	        <h2>License:</h2>
    	        
    	        <input type="password" name="password" id="password" value="">
    	        
    	        <button  id="INBBE-CHATBOT-ADMIN-login"> Login </button>
				    
    		
	        </div>
	    <?php
	    }
	    else{
	        ?>
	        <div id="admin-session-logout">
	            <button id="INBBE-CHATBOT-ADMIN-logout"> Logout </button>
	        </div>
	        <?php
	    }
	    ?>
	    </div>