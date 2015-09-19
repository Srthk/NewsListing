
//FUNCTIONS FOR INDEX.PHP

function showCount(id) {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	                var str = xmlhttp.responseText.split(",");
	                if(str == ""){
	                	document.location = "login.php?submit=yes";
	                	return;
	                }
	                document.getElementById("upcount" + id).innerHTML = str[0];
	                if(str[1] == "up"){
						$('#upvote' + id).removeClass('down');
						$('#upvote' + id).addClass('up');
	                }	
	                else if(str[1] == "down"){
						$('#upvote' + id).removeClass('up');
						$('#upvote' + id).addClass('down');
	                }
	            }
	        }
	        xmlhttp.open("GET", "upvote_count.php?for=" + id, true);
	        xmlhttp.send();
	    }

	    function verifyUserName(str){
			 if (str.length == 0) { 
			        document.getElementById("userValidation").innerHTML = "<span style='color:red'>Please enter a username.</span>";
			        return;
			    } else {
			        var xmlhttp = new XMLHttpRequest();
			        xmlhttp.onreadystatechange = function() {
			            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			                document.getElementById("userValidation").innerHTML = xmlhttp.responseText;
			            }
			        }
			        xmlhttp.open("GET", "signup.php?username=" + str, true);
			        xmlhttp.send();
			    }
	    }

	    function checkPasswordMatch() {
		    var password = $("#signupPassword").val();
		    var confirmPassword = $("#rePassword").val();

		    if (password != confirmPassword)
		        $("#divCheckPasswordMatch").html("<span style='color:red'>Passwords do not match!</span>");
		    else
		        $("#divCheckPasswordMatch").html("<span style='color:green'>Passwords match.</span>");
		}

		$(document).ready(function () {
		   $("#rePassword").keyup(checkPasswordMatch);
		});

		function checkPassword() {
		    var password = $("#signupPassword").val();

		    if (password.length < 6)
		        $("#divCheckPassword").html("<span style='color:red'>Password too small (min. 6 characters).</span>");
		    else
				$("#divCheckPassword").html("<span style='color:green'>Password valid.</span>");

		}
		$(document).ready(function () {
		   $("#signupPassword").keyup(checkPassword);
		});

//FUNCTIONS FOR HEADER.PHP

$(document).ready(function(){
		    //Handles menu drop down
		    $('.dropdown-menu').find('form').click(function (e) {
		        e.stopPropagation();
		    });
		});

		 function verifyUserNameNav(str){
			 if (str.length == 0) { 
			        document.getElementById("userValidationNav").innerHTML = "<span style='color:red'>Please enter a username.</span>";
			        return;
			    } else {
			        var xmlhttp = new XMLHttpRequest();
			        xmlhttp.onreadystatechange = function() {
			            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			                document.getElementById("userValidationNav").innerHTML = xmlhttp.responseText;
			            }
			        }
			        xmlhttp.open("GET", "signup.php?username=" + str, true);
			        xmlhttp.send();
			    }
	    }

	    function checkPasswordMatchNav() {
		    var password = $("#signupPasswordNav").val();
		    var confirmPassword = $("#rePasswordNav").val();

		    if (password != confirmPassword){
		        $("#passwordValidationNav").html("<span style='color:red'>Passwords do not match!</span>");		    	
		    }
		    else{
		          $("#passwordValidationNav").html("<span style='color:green'>Passwords match.</span>");		    	
		    }
		}

		$(document).ready(function () {
		   $("#rePasswordNav").keyup(checkPasswordMatchNav);
		});

		function checkPasswordNav() {
		    var password = $("#signupPasswordNav").val();

		    if (password.length < 6)
		        $("#passwordCheck").html("<span style='color:red'>Password too small (min. 6 characters).</span>");
		    else
				$("#passwordCheck").html("<span style='color:green'>Password valid.</span>");

		}



 function getId(id) {
       return document.getElementById(id);
   }
   function validation() {
       getId("s_post").style.display="none";
       getId("waiting").style.display="";
       return true;
   }
