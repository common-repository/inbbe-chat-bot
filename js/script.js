jQuery(document).ready(function() { 
   jQuery(document).keypress(function (e) {
     var key = e.which;
     if(key == 13)  // the enter key code
      {
          jQuery(".INBBE-CHATBOT-as-read").click();
      }
   });
   jQuery(".INBBE-CHATBOT-as-read").click(function () {
    //console.log('The function is hooked up');
    message = jQuery('#INBBE-CHATBOT-text-input').val()
    jQuery('#INBBE-CHATBOT-text-input').val(" ")
    INBBE_CHATBOT_create_message(message, pw_script_vars.user_img)
    jQuery.ajax({
        
        type: "POST",
        url: pw_script_vars.ajaxurl,
       
        data: {
            action: 'INBBECHATBOTmessageasread',
            message: message,
            nonce: pw_script_vars.nonce,
        },
        success: function (output) {
           //console.log(output);
           output = output.replace("}", "}__");
           output = output.split("__")[0]
           response = JSON.parse(output)
           resp = response["resp"]
           resp = INBBE_CHATBOT_check_accents(resp)
           INBBE_CHATBOT_create_resp(resp, pw_script_vars.profile_img)
           var objDiv = document.getElementById("INBBE-CHATBOT-msg-page");
           objDiv.scrollTop = objDiv.scrollHeight;
        }
        });
    });
});

function INBBE_CHATBOT_display_chat(){
	var x = document.getElementById("INBBE-CHATBOT-container-top");
	  if (x.style.display === "none") {
	    x.style.display = "block";
	  } else {
	    x.style.display = "none";
	  }
	  var x = document.getElementById("INBBE-CHATBOT-start");
	  if (x.style.display === "none") {
	    x.style.display = "block";
	  } else {
	    x.style.display = "none";
	  }
	}
	document.getElementById("INBBE-CHATBOT-container-top").style.display="none"
function INBBE_CHATBOT_create_message(message, url){ 

		chat_page = document.getElementById("INBBE-CHATBOT-chat-page")
		msg_page = document.getElementById("INBBE-CHATBOT-msg-page")

		outgoing_chats = document.createElement("div")
		outgoing_chats.setAttribute("class", "INBBE-CHATBOT-outgoing-chats")

		outgoing_chats_msg = document.createElement("div")
		outgoing_chats_msg.setAttribute("class", "INBBE-CHATBOT-outgoing-chats-msg")

		msg_p = document.createElement("p")
		msg_p.innerHTML = message

		outgoing_chats_msg.appendChild(msg_p)
		
		outgoing_chats_img = document.createElement("div")
		outgoing_chats_img.setAttribute("class", "INBBE-CHATBOT-outgoing-chats-img")
		
		img = document.createElement("img")
		img.setAttribute("src",url)
		img.setAttribute("class","INBBE-CHATBOT-outgoing-img")

		outgoing_chats_img.appendChild(img)
		outgoing_chats.appendChild(outgoing_chats_msg)
		outgoing_chats.appendChild(outgoing_chats_img)

		msg_page.appendChild(outgoing_chats)

	}

function INBBE_CHATBOT_create_resp(message, image){

		
		msg_page = document.getElementById("INBBE-CHATBOT-msg-page")

		received_chats = document.createElement("div")
		received_chats.setAttribute("class", "INBBE-CHATBOT-received-chats")


		received_chats_img = document.createElement("div")
		received_chats_img.setAttribute("class", "INBBE-CHATBOT-received-chats-img")
		
		img = document.createElement("img")
		img.setAttribute("src",image)
		img.setAttribute("class","INBBE-CHATBOT-received-img")

		received_msg = document.createElement("div")
		received_msg.setAttribute("class", "INBBE-CHATBOT-received-msg")

		received_msg_inbox = document.createElement("div")
		received_msg_inbox.setAttribute("class", "INBBE-CHATBOT-received-msg-inbox")

		msg_p = document.createElement("p")
		msg_p.innerHTML = message


		received_chats_img.appendChild(img)
		received_chats.appendChild(received_chats_img)
		received_msg_inbox.appendChild(msg_p)
		received_msg.appendChild(received_msg_inbox)
		received_chats.appendChild(received_msg)

		msg_page.appendChild(received_chats)
		
	}
	
function INBBE_CHATBOT_check_accents(resp){
        String.prototype.allReplace = function(obj) {
            var retStr = this;
            for (var x in obj) {
                retStr = retStr.replace(new RegExp(x, "g"), obj[x]);
            }
            return retStr;
        };


          if (resp.includes("acento_a")){
            resp =resp.replace("acento_a", "á")
            resp.replace(/acento_a/g, "á") 
            resp = resp.allReplace({"acento_a":"á"});
          }


          if (resp.includes("acento_e")){
            resp = resp.replace("acento_e", "é")
            resp.replace(/acento_e/g, "é")
            resp = resp.allReplace({"acento_e":"é"});
          }

          if (resp.includes("acento_i")){
            resp = resp.replace("acento_i", "í")
            resp.replace(/acento_i/g, "í")
            resp = resp.allReplace({"acento_i": "í"});
          }


          if (resp.includes("acento_o")){
            resp =resp.replace("acento_o", "ó")
            resp.replace(/acento_o/g, "ó")
            resp =resp.allReplace({"acento_o":"ó"});
          }            

          
          if (resp.includes("acento_u")){
            resp =resp.replace("acento_u", "ú")
            resp.replace(/acento_u/g, "ú")
            resp =resp.allReplace({"acento_u": "ú"});
          }

          if (resp.includes("acento_coma")){
            resp = resp.replace("acento_coma", ",")
            resp.replace(/acento_coma/g, ",")
            resp =resp.allReplace({"acento_coma": ","});
          }
          
          if (resp.includes("acento_n")){
            resp = resp.replace("acento_n", "ñ")
            resp.replace(/acento_n/g, "ñ") 
            resp =resp.allReplace({"acento_n":"ñ"});
          }

        return resp
      }

function INBBE_CHATBOT_resize_web(w, h){
		var container = document.getElementById("INBBE-CHATBOT-container-top")
		var chat = document.getElementById("INBBE-CHATBOT-chat-bot")
		var page = document.getElementById("INBBE-CHATBOT-msg-page")
		//console.log(w,h)
		if (h < 500){
		    page.style.height = "200px";
		    container.style.top="15%"
		    container.style.height="10%";
		    
		}else if (h < 750){
		    page.style.height = "250px";
		    container.style.top="35%"
		    container.style.height="10%";
		    
		
		}else{
		    container.style.top="50%"
		    container.style.bottom="6%"
		    page.style.height = "328px";
		}
		
		
		if(w < 320){
			chat.style.left = "38%";
			container.style.left="10%"
			container.style.width="230px";
			container.style.maxWidth="230px";

			
		} 
		else if(w < 600){
		    
			chat.style.left = "38%";
			container.style.left="28%"
			container.style.width="250px";
			container.style.maxWidth="250px";
			
		}
		else if(w < 800){
		    
			chat.style.left = "80%";
			container.style.left="60%"
			container.style.width="250px";
			container.style.maxWidth="250px";
			
		}
		else if(w < 1400){
			chat.style.left = "80%";
			container.style.left="72%"
			container.style.width="250px";
			container.style.maxWidth="250px";
			
		}
		else{

			chat.style.left = "90%";
			container.style.left="82%"
			container.style.width="250px";
			container.style.maxWidth="250px";
			
		}
	}
function INBBE_CHATBOT_displayWindowSize(){
        var w = document.documentElement.clientWidth;
        var h = document.documentElement.clientHeight;
        
        INBBE_CHATBOT_resize_web(w, h)
    }

    
window.addEventListener("resize", INBBE_CHATBOT_displayWindowSize);
INBBE_CHATBOT_displayWindowSize();