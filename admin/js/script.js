jQuery(document).ready( function(){
    
   jQuery("#INBBE-CHATBOT-ADMIN-login").click(function () {
    //console.log('The function is hooked up');
    password = document.getElementById("password").value
    
    
    jQuery.ajax({
        
        type: "POST",
        url: pw_script_admin_vars.ajaxurl,
        data: {
            action: 'INBBECHATBOTadminlogin',
            password: password,
            nonce: pw_script_admin_vars.nonce
        },
        success: function (output) {
           output = output.split("{")[0]
           console.log('Welcome ',output,'!')
           location.reload();
        }
        });
    });
    
    jQuery("#INBBE-CHATBOT-ADMIN-logout").click(function () {
    //console.log('The function is hooked up');
    jQuery.ajax({
        
        type: "POST",
        url: pw_script_admin_vars.ajaxurl,
        data: {
            action: 'INBBECHATBOTadminlogout',
            
            nonce: pw_script_admin_vars.nonce
        },
        success: function (output) {
           
           
           location.reload();
        }
        });
    });
    
       
});
