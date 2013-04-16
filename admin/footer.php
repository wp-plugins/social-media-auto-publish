

<div style="clear: both;"></div>

    <style>
    
    .xyz_feedback{
    background: #CEEAF7; /* Old browsers */
border: 1px solid #64cfe8;
border-radius:3px;
width: 98%;    
height:28px;
   padding:5px 5px;
    font-weight: bold;
    
    }
    
    
    .xyz_feedback a{
    text-decoration: none
    }  
       
    .xyz_subscribe{
    background: #bae598; /* Old browsers */
border: 1px solid #4d8a1d;
border-radius:3px;
width: 98%;    
    padding:5px 5px;
height:28px;
    
    }
  .xyz_subscribe  td{
    padding:0;
    }
    
    .submit_smap{
	background:#25A6E1;
	background:-moz-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#25A6E1),color-stop(100%,#188BC0));
	background:-webkit-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:-o-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:-ms-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#25A6E1",endColorstr="#188BC0",GradientType=0);
	padding:1px 13px;
	color:#ffffff;
	font-family:"Helvetica Neue",sans-serif;
	font-size:13px;
	cursor:pointer;	
	color:#FFFFFF !important;border-radius:4px !important;
	border:1px solid #1A87B9;height: 25px;
}
    
    </style>
<p></p>

<div style="width: 100%">
		
    <div class="xyz_feedback">

   
   <a target="_blank" href="http://xyzscripts.com/donate/1" class="xyz_donate">Donate a dollar</a> - 
   <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/social-media-auto-publish" class="xyz_star">Rate this plugin</a> -   
   <a target="_blank" href="http://xyzscripts.com/support/" class="xyz_suggest">Suggestions</a> - 
<a target="_blank" href="http://facebook.com/xyzscripts" class="xyz_fbook">Like us on facebook</a> -   
   <a target="_blank" href="http://twitter.com/xyzscripts" class="xyz_twitt">Follow us on twitter</a> -   
   <a target="_blank" href="https://plus.google.com/101215320403235276710/" class="xyz_gplus">+1 us on Google+</a>
      
   
    </div>
    
   <p></p>
    
<div class="xyz_subscribe">

<script language="javascript">
function check_email(emailString)
{
    var mailPattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var matchArray = emailString.match(mailPattern);
    if (emailString.length == 0)
    return false;
       
    if (matchArray == null)    {
    return false;
    }else{
    return true;
    }
}

   
function verify_lists(form)
{
   
    var total=0;
    var checkBox=form['chk[]'];
   
    if(checkBox.length){
   
    for(var i=0;i<checkBox.length;i++){
    checkBox[i].checked?total++:null;
    }
    }else{
       
    checkBox.checked?total++:null;
       
    }
    if(total>0){
    return true;
    }else{
    return false;
    }

}
   
function verify_fields()
{

    if(check_email(document.email_subscription.email.value) == false){
    alert("Please check whether the email is correct.");
    document.email_subscription.email.select();
    return false;
    }else if(verify_lists(document.email_subscription)==false){
    alert("Select atleast one list.");
    }
    else{
    document.email_subscription.submit();
    }

}
</script>
<?php global $current_user; get_currentuserinfo(); ?>
<form action=http://xyzscripts.com/newsletter/index.php?page=list/subscribe method="post" name="email_subscription" id="email_subscription" >
<input type="hidden" name="fieldNameIds" value="1,">
<input type="hidden" name="redirActive" value="http://xyzscripts.com/subscription/pending/XYZWPSMPPRE">
<input type="hidden" name="redirPending" value="http://xyzscripts.com/subscription/active/XYZWPSMPPRE">
<input type="hidden" name="mode" value="1">
   
<b>Stay tuned to our updates :</b>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

Name  : 
<input style="border: 1px solid #3fafe3; margin-right:10px;" type="text" name="field1" value="<?php  
if ($current_user->user_firstname != "" || $current_user->user_lastname != "") 
{
	echo $current_user->user_firstname . " " . $current_user->user_lastname; 
} 
else if (strcasecmp($current_user->display_name, 'admin')!=0 && strcasecmp($current_user->display_name , "administrator")!=0 ) 
{
	echo $current_user->display_name;
} 
else if (strcasecmp($current_user->user_login ,"admin")!=0 && strcasecmp($current_user->user_login , "administrator")!=0 ) 
{
	echo $current_user->user_login;	
}
?>"  >

Email Address : 
<input style="border: 1px solid #3fafe3;" name="email"
type="text" value="<?php 	echo $current_user->user_email; ?>" /><span style="color:#FF0000">*</span>           

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input class="submit_smap" type="submit" value="Subscribe" name="Submit"  onclick="javascript: if(!verify_fields()) return false; " />

<input type="hidden" name="listName" value="7,1,"/>
</form>
				


</div>   


    <div style="clear: both;"></div>
 <div style="width: 99%">
<div style="padding-top: 10px;float:left;">
Powered by <a href="http://xyzscripts.com" target="_blank">XYZScripts</a>
</div>
<div style="padding-top: 10px;float:right ;">
See Also : 
	
	<a target="_blank"	href="http://wordpress.org/extend/plugins/lightbox-pop/">Lightbox Pop</a> ★
	<a target="_blank"	href="http://wordpress.org/extend/plugins/full-screen-popup/">Full Screen Popup</a> ★
	<a target="_blank"	href="http://wordpress.org/extend/plugins/popup-dialog-box/">Popup Dialog Box</a> ★
	<a target="_blank"	href="http://wordpress.org/extend/plugins/quick-bar/">Quick Bar</a> ★
	<a target="_blank"	href="http://wordpress.org/extend/plugins/quick-box-popup/">Quick Box Popup</a> ★
	<a target="_blank"	href="http://wordpress.org/extend/plugins/insert-html-snippet/">Insert HTML Snippet</a> ★
	<a target="_blank"	href="http://wordpress.org/extend/plugins/newsletter-manager/">Newsletter Manager</a>★
<a target="_blank"	href="http://wordpress.org/extend/plugins/contact-form-manager/">Contact Form Manager</a>
</div>
 </div>   

    <div style="clear: both;"></div>

</div>
    <p style="clear: both;"></p>