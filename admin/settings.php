<?php

global $current_user;
$auth_varble=0;
get_currentuserinfo();
$imgpath= plugins_url()."/social-media-auto-publish/admin/images/";
$heimg=$imgpath."support.png";
$ms1="";
$ms2="";
$ms3="";
$ms4="";
$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=1');
$luid=$current_user->ID;

require( dirname( __FILE__ ) . '/authorization.php' );

$erf=0;
if(isset($_POST['fb']))
{

	$ss=array();
	if(isset($_POST['smap_pages_list']))
	$ss=$_POST['smap_pages_list'];
	
	$smap_pages_list_ids="";


	if($ss!="")
	{
		for($i=0;$i<count($ss);$i++)
		{
			$smap_pages_list_ids.=$ss[$i].",";
		}

	}
	else
		$smap_pages_list_ids.=-1;

	$smap_pages_list_ids=rtrim($smap_pages_list_ids,',');


	update_option('xyz_smap_pages_ids',$smap_pages_list_ids);



	$applidold=get_option('xyz_smap_application_id');
	$applsecretold=get_option('xyz_smap_application_secret');
	$fbidold=get_option('xyz_smap_fb_id');
	$posting_method=$_POST['xyz_smap_po_method'];
	$posting_permission=$_POST['xyz_smap_post_permission'];
	$appid=$_POST['xyz_smap_application_id'];
	$appsecret=$_POST['xyz_smap_application_secret'];
	$messagetopost=$_POST['xyz_smap_message'];
	$fbid=$_POST['xyz_smap_fb_id'];
	if($appid=="" )
	{
		$ms1="Please fill facebook application id.";
		$erf=1;
	}
	elseif($appsecret=="" )
	{
		$ms2="Please fill facebook application secret.";
		$erf=1;
	}
	elseif($fbid=="" )
	{
		$ms3="Please fill facebook user id.";
		$erf=1;
	}
	elseif($messagetopost=="" )
	{
		$ms4="Please fill message format for posting.";
		$erf=1;
	}
	else
	{
		$erf=0;
		if($appid!=$applidold || $appsecret!=$applsecretold || $fbidold!=$fbid)
		{
			update_option('xyz_smap_af',1);
		}
		if($messagetopost=="")
		{
			$messagetopost="New post added at {BLOG_TITLE} - {POST_TITLE}";
		}

		update_option('xyz_smap_application_id',$appid);
		update_option('xyz_smap_post_permission',$posting_permission);
		update_option('xyz_smap_application_secret',$appsecret);
		update_option('xyz_smap_fb_id',$fbid);
		update_option('xyz_smap_po_method',$posting_method);
		update_option('xyz_smap_message',$messagetopost);

		$url = 'https://graph.facebook.com/'.$fbid;
		$contentget=wp_remote_get($url);
		//if(isset($contentget))
		$result1=$contentget['body'];
		$pagearray = json_decode($result1);
		if(isset($pagearray->id))
		$page_id=$pagearray->id;
		else
			$page_id="";

		update_option('xyz_smap_fb_numericid',$page_id);

	}
}




$tms1="";
$tms2="";
$tms3="";
$tms4="";
$tms5="";
$tms6="";
$tredirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&authtwit=1');
$luid=$current_user->ID;


$terf=0;
if(isset($_POST['twit']))
{



	//$posting_method=$_POST['xyz_smap_po_method'];

	$tappid=$_POST['xyz_smap_twconsumer_id'];
	$tappsecret=$_POST['xyz_smap_twconsumer_secret'];
	//$messagetopost=$_POST['xyz_smap_twmessage'];
	$twid=$_POST['xyz_smap_tw_id'];
	$taccess_token=$_POST['xyz_smap_current_twappln_token'];
	$taccess_token_secret=$_POST['xyz_smap_twaccestok_secret'];
	$tposting_permission=$_POST['xyz_smap_twpost_permission'];
	$tposting_image_permission=$_POST['xyz_smap_twpost_image_permission'];
	$tmessagetopost=$_POST['xyz_smap_twmessage'];
	if($tappid=="" )
	{
		$terf=1;
		$tms1="Please fill consumer id.";

	}
	elseif($tappsecret=="" )
	{
		$tms2="Please fill consumer secret.";
		$terf=1;
	}
	elseif($twid=="" )
	{
		$tms3="Please fill twitter username.";
		$terf=1;
	}
	elseif($taccess_token=="")
	{
		$tms4="Please fill twitter access token.";
		$terf=1;
	}
	elseif($taccess_token_secret=="")
	{
		$tms5="Please fill twitter access token secret.";
		$terf=1;
	}
	elseif($tmessagetopost=="")
	{
		$tms6="Please fill mssage format for posting.";
		$terf=1;
	}
	else
	{
		$terf=0;
		if($tmessagetopost=="")
		{
			$tmessagetopost="{POST_TITLE}-{PERMALINK}";
		}

		update_option('xyz_smap_twconsumer_id',$tappid);
		update_option('xyz_smap_twconsumer_secret',$tappsecret);
		update_option('xyz_smap_tw_id',$twid);
		update_option('xyz_smap_current_twappln_token',$taccess_token);
		update_option('xyz_smap_twaccestok_secret',$taccess_token_secret);
		update_option('xyz_smap_twmessage',$tmessagetopost);
		update_option('xyz_smap_twpost_permission',$tposting_permission);
		update_option('xyz_smap_twpost_image_permission',$tposting_image_permission);
		?>


<?php 
	}
}

if((isset($_POST['twit']) && $terf==0)|| (isset($_POST['fb']) && $erf==0))
{
	?>

<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php }
if((isset($_POST['twit']) && $terf==1)|| (isset($_POST['fb']) && $erf==1))
{
	?>
<div class="system_notice_area_style0" id="system_notice_area">
	<?php 
	if(isset($_POST['fb']))
	{
		echo $ms1;echo $ms2;echo $ms3;echo $ms4;
	}
	else
	{echo $tms1;echo $tms2;echo $tms3;echo $tms4;echo $tms5;echo $tms6;
	}
	?>
	&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php } ?>
<script type="text/javascript">
function detdisplay(id)
{
	document.getElementById(id).style.display='';
}
function dethide(id)
{
	document.getElementById(id).style.display='none';
}

</script>

<div style="width: 100%">

	<h2>
		 <img src="<?php echo plugins_url()?>/social-media-auto-publish/admin/images/facebook-logo.png" height="16px"> Facebook Settings
	</h2>
	<?php
	$af=get_option('xyz_smap_af');
	$appid=get_option('xyz_smap_application_id');
	$appsecret=get_option('xyz_smap_application_secret');
	$fbid=get_option('xyz_smap_fb_id');
	$posting_method=get_option('xyz_smap_po_method');
	$posting_message=get_option('xyz_smap_message');
	if($af==1 && $appid!="" && $appsecret!="" && $fbid!="")
	{
		?>
	<span style="color: red;">Application needs authorisation</span> <br>
	<form method="post">

		<input type="submit" class="submit_smap_new" name="fb_auth"
			value="Authorize	" /><br><br>

	</form>
	<?php }


	if(isset($_GET['auth']) && $_GET['auth']==1)
	{
		?>

	<span style="color: green;">Application is authorized, go posting.
	</span><br>

	<?php 	
	}
	?>

	
	<table class="widefat" style="width: 99%;background-color: #FFFBCC">
	<tr>
	<td id="bottomBorderNone">
	
	<div>


		<b>Note :</b> You have to create a Facebook application before filling the following details.
		<b><a href="https://developers.facebook.com/apps" target="_blank">Click here</a></b> to create new Facebook application. 
		<br>In the application page in facebook, navigate to <b>Apps > Settings > Edit settings > Website > Site URL</b>. Set the site url as 
		<span style="color: red;"><?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?></span>
<br>For detailed step by step instructions <b><a href="http://docs.xyzscripts.com/wordpress-plugins/social-media-auto-publish/creating-facebook-application/" target="_blank">Click here</a></b>.
	</div>

	</td>
	</tr>
	</table>
	
	<form method="post">
		<input type="hidden" value="config">





			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat" style="width: 99%">
				<tr valign="top">
					<td width="50%">Application id
					</td>
					<td><input id="xyz_smap_application_id"
						name="xyz_smap_application_id" type="text"
						value="<?php if($ms1=="") {echo get_option('xyz_smap_application_id');}?>" />
					</td>
				</tr>

				<tr valign="top">
					<td>Application secret<?php   $apsecret=get_option('xyz_smap_application_secret');?>
						
					</td>
					<td><input id="xyz_smap_application_secret"
						name="xyz_smap_application_secret" type="text"
						value="<?php if($ms2=="") {echo $apsecret; }?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Facebook user id 
					</td>
					<td><input id="xyz_smap_fb_id" name="xyz_smap_fb_id" type="text"
						value="<?php if($ms3=="") {echo get_option('xyz_smap_fb_id');}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_fb')" onmouseout="dethide('xyz_fb')">
						<div id="xyz_fb" class="informationdiv" style="display: none;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.
						</div></td>
					<td><textarea id="xyz_smap_message" name="xyz_smap_message"><?php if($ms4==""){ 
								echo get_option('xyz_smap_message');
							}?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td>Posting method
					</td>
					<td>
					<select id="xyz_smap_po_method" name="xyz_smap_po_method">
							<option value="3"
				<?php  if(get_option('xyz_smap_po_method')==3) echo 'selected';?>>Simple text message</option>
				
				<optgroup label="Text message with image">
					<option value="4"
					<?php  if(get_option('xyz_smap_po_method')==4) echo 'selected';?>>Upload image to app album</option>
					<option value="5"
					<?php  if(get_option('xyz_smap_po_method')==5) echo 'selected';?>>Upload image to timeline album</option>
				</optgroup>
				
				<optgroup label="Text message with attached link">
					<option value="1"
					<?php  if(get_option('xyz_smap_po_method')==1) echo 'selected';?>>Attach
						your blog post</option>
					<option value="2"
					<?php  if(get_option('xyz_smap_po_method')==2) echo 'selected';?>>
						Share a link to your blog post</option>
					</optgroup>
					</select>
					</td>
				</tr>
				<tr valign="top">
					<td>Enable auto publish post to my facebook wall
					</td>
					<td><select id="xyz_smap_post_permission"
						name="xyz_smap_post_permission"><option value="0"
						<?php  if(get_option('xyz_smap_post_prmission')==0) echo 'selected';?>>
								No</option>
							<option value="1"
							<?php  if(get_option('xyz_smap_post_permission')==1) echo 'selected';?>>Yes</option>
					</select>
					</td>
				</tr>
				<?php 

				$xyz_acces_token=get_option('xyz_smap_fb_token');
				if($xyz_acces_token!=""){

					$offset=0;$limit=100;$data=array();
					$fbid=get_option('xyz_smap_fb_id');
					do
					{

						$pp=wp_remote_get("https://graph.facebook.com/$fbid/accounts?access_token=$xyz_acces_token&limit=$limit&offset=$offset");
						$result1=$pp['body'];
						$pagearray1 = json_decode($result1);

						$data = array_merge($data, $pagearray1->data);
						$offset += $limit;
					}while(array_key_exists("next", $pagearray1->paging));




					$count=count($data);


					if($count>0)
					{
						$smap_pages_ids1=get_option('xyz_smap_pages_ids');
						$smap_pages_ids=array();
						if($smap_pages_ids1!="")
							$smap_pages_ids=explode(",",$smap_pages_ids1);







						?>

				<tr valign="top">
					<td>Select facebook pages for auto	publish
					</td>
					<td><select name="smap_pages_list[]" multiple="multiple">
							<option value="-1"
							<?php if(in_array(-1, $smap_pages_ids)) echo "selected" ?>>Profile	Page</option>
							<?php 
							for($i=0;$i<$count;$i++)
							{
								?>
							<option
								value="<?php  echo $data[$i]->id."-".$data[$i]->access_token;?>"
								<?php if(in_array($data[$i]->id."-".$data[$i]->access_token, $smap_pages_ids)) echo "selected" ?>>

								<?php echo $data[$i]->name; ?>
							</option>
							<?php }?>
					</select>
					</td>
				</tr>


				<?php }	
				}?>
				<tr><td   id="bottomBorderNone"></td>
					<td  id="bottomBorderNone">
							<input type="submit" class="submit_smap_new"
								style=" margin-top: 10px; "
								name="fb" value="Save" />
					</td>
				</tr>
			</table>

	</form>



	<h2>
		 <img	src="<?php echo plugins_url()?>/social-media-auto-publish/admin/images/twitter-logo.png" height="16px"> Twitter Settings
	</h2>
	<?php



	$tappid=get_option('xyz_smap_twconsumer_id');
	$tappsecret=get_option('xyz_smap_twconsumer_secret');
	$twid=get_option('xyz_smap_tw_id');
	$taccess_token=get_option('xyz_smap_current_twappln_token');
	//$posting_method=get_option('xyz_smap_po_method');
	//$posting_message=get_option('xyz_smap_twmessage');



	?>


<table class="widefat" style="width: 99%;background-color: #FFFBCC">
<tr>
<td id="bottomBorderNone">
	<div>
		<b>Note :</b> You have to create a Twitter application before filling in following fields. 	
		<br><b><a href="https://dev.twitter.com/apps/new" target="_blank">Click here</a></b> to create new application. Specify the website for the application as :	<span style="color: red;"><?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?>		 </span> 
		 <br>In the twitter application, navigate to	<b>Settings > Application Type > Access</b>. Select <b>Read and Write</b> option. 
		 <br>After updating access, navigate to <b>Details > Your access token</b> in the application and	click <b>Create my access token</b> button.
		<br>For detailed step by step instructions <b><a href="http://docs.xyzscripts.com/wordpress-plugins/social-media-auto-publish/creating-twitter-application/" target="_blank">Click here</a></b>.

	</div>
</td>
</tr>
</table>


	<form method="post">
		<input type="hidden" value="config">



			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat" style="width: 99%">
				<tr valign="top">
					<td width="50%">Consumer id
					</td>
					<td><input id="xyz_smap_twconsumer_id"
						name="xyz_smap_twconsumer_id" type="text"
						value="<?php if($tms1=="") {echo get_option('xyz_smap_twconsumer_id');}?>" />
					</td>
				</tr>

				<tr valign="top">
					<td>Consumer secret
					</td>
					<td><input id="xyz_smap_twconsumer_secret"
						name="xyz_smap_twconsumer_secret" type="text"
						value="<?php if($tms2=="") { echo get_option('xyz_smap_twconsumer_secret'); }?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Twitter username
					</td>
					<td><input id="xyz_smap_tw_id" class="al2tw_text"
						name="xyz_smap_tw_id" type="text"
						value="<?php if($tms3=="") {echo get_option('xyz_smap_tw_id');}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Access token
					</td>
					<td><input id="xyz_smap_current_twappln_token" class="al2tw_text"
						name="xyz_smap_current_twappln_token" type="text"
						value="<?php if($tms4=="") {echo get_option('xyz_smap_current_twappln_token');}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Access	token secret
					</td>
					<td><input id="xyz_smap_twaccestok_secret" class="al2tw_text"
						name="xyz_smap_twaccestok_secret" type="text"
						value="<?php if($tms5=="") {echo get_option('xyz_smap_twaccestok_secret');}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_tw')" onmouseout="dethide('xyz_tw')">
						<div id="xyz_tw" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.
						</div></td>
					<td><textarea id="xyz_smap_twmessage" name="xyz_smap_twmessage"	><?php if($tms6=="") {
								echo get_option('xyz_smap_twmessage');
							}?>
						</textarea>
					</td>
				</tr>
				
				<tr valign="top">
					<td>Attach image to twitter post
					</td>
					<td><select id="xyz_smap_twpost_image_permission"
						name="xyz_smap_twpost_image_permission">
							<option value="0"
							<?php  if(get_option('xyz_smap_twpost_image_permission')==0) echo 'selected';?>>
								No</option>
							<option value="1"
							<?php  if(get_option('xyz_smap_twpost_image_permission')==1) echo 'selected';?>>Yes</option>
					</select>
					</td>
				</tr>
				
				<tr valign="top">
					<td>Enable auto publish	posts to my twitter account
					</td>
					<td><select id="xyz_smap_twpost_permission"
						name="xyz_smap_twpost_permission">
							<option value="0"
							<?php  if(get_option('xyz_smap_twpost_prmission')==0) echo 'selected';?>>
								No</option>
							<option value="1"
							<?php  if(get_option('xyz_smap_twpost_permission')==1) echo 'selected';?>>Yes</option>
					</select>
					</td>
				</tr>

				


				<tr>
			<td   id="bottomBorderNone"></td>
					<td   id="bottomBorderNone">
							<input type="submit" class="submit_smap_new"
								style=" margin-top: 10px; "
								name="twit" value="Save" />
					</td>
				</tr>
			</table>

	</form>

	<?php 

	if(isset($_POST['bsettngs']))
	{


		$xyz_smap_include_pages=$_POST['xyz_smap_include_pages'];

		if($_POST['xyz_smap_cat_all']=="All")
			$smap_category_ids=$_POST['xyz_smap_cat_all'];//redio btn name
		else
			$smap_category_ids=$_POST['xyz_smap_sel_cat'];//dropdown

		$xyz_customtypes="";
		
        if(isset($_POST['post_types']))
		$xyz_customtypes=$_POST['post_types'];


		$smap_customtype_ids="";

		if($xyz_customtypes!="")
		{
			for($i=0;$i<count($xyz_customtypes);$i++)
			{
				$smap_customtype_ids.=$xyz_customtypes[$i].",";
			}

		}
		$smap_customtype_ids=rtrim($smap_customtype_ids,',');


		update_option('xyz_smap_include_pages',$xyz_smap_include_pages);
		update_option('xyz_smap_include_categories',$smap_category_ids);
		update_option('xyz_smap_include_customposttypes',$smap_customtype_ids);

	}

	$xyz_credit_link=get_option('xyz_credit_link');
	$xyz_smap_include_pages=get_option('xyz_smap_include_pages');
	$xyz_smap_include_categories=get_option('xyz_smap_include_categories');
	$xyz_smap_include_customposttypes=get_option('xyz_smap_include_customposttypes');


	?>
		<h2>Basic Settings</h2>


		<form method="post">

			<table class="widefat" style="width: 99%">

				<tr valign="top">

					<td  colspan="1" width="50%">Publish wordpress `pages` to social media
					</td>
					<td><select name="xyz_smap_include_pages">

							<option value="1"
							<?php if($xyz_smap_include_pages=='1') echo 'selected'; ?>>Yes</option>

							<option value="0"
							<?php if($xyz_smap_include_pages!='1') echo 'selected'; ?>>No</option>
					</select>
					</td>
				</tr>

				<tr valign="top">

					<td  colspan="1">Select wordpress categories for auto publish
					</td>
					<td><input type="hidden"
						value="<?php echo $xyz_smap_include_categories;?>"
						name="xyz_smap_sel_cat" id="xyz_smap_sel_cat"> <input type="radio"
						name="xyz_smap_cat_all" id="xyz_smap_cat_all" value="All"
						onchange="rd_cat_chn(1,-1)"
						<?php if($xyz_smap_include_categories=="All") echo "checked"?>>All<font
						style="padding-left: 10px;"></font><input type="radio"
						name="xyz_smap_cat_all" id="xyz_smap_cat_all" value=""
						onchange="rd_cat_chn(1,1)"
						<?php if($xyz_smap_include_categories!="All") echo "checked"?>>Specific

						<span id="cat_dropdown_span"><br /> <br /> <?php 


						$args = array(
								'show_option_all'    => '',
								'show_option_none'   => '',
								'orderby'            => 'name',
								'order'              => 'ASC',
								'show_last_update'   => 0,
								'show_count'         => 0,
								'hide_empty'         => 0,
								'child_of'           => 0,
								'exclude'            => '',
								'echo'               => 0,
								'selected'           => '1 3',
								'hierarchical'       => 1,
								'name'               => 'xyz_smap_catlist',
								'id'                 => 'xyz_smap_catlist',
								'class'              => 'postform',
								'depth'              => 0,
								'tab_index'          => 0,
								'taxonomy'           => 'category',
								'hide_if_empty'      => false );

						if(count(get_categories($args))>0)
							echo str_replace( "<select", "<select multiple onClick=setcat(this) style='width:200px;height:100px;border:1px solid #cccccc;'", wp_dropdown_categories($args));
						else
							echo "NIL";

						?><br /> <br /> </span>
					</td>
				</tr>


				<tr valign="top">

					<td  colspan="1">Select wordpress custom post types for auto publish</td>
					<td><?php 

					$args=array(
							'public'   => true,
							'_builtin' => false
					);
					$output = 'names'; // names or objects, note names is the default
					$operator = 'and'; // 'and' or 'or'
					$post_types=get_post_types($args,$output,$operator);

					$ar1=explode(",",$xyz_smap_include_customposttypes);
					$cnt=count($post_types);
					foreach ($post_types  as $post_type ) {

						echo '<input type="checkbox" name="post_types[]" value="'.$post_type.'" ';
						if(in_array($post_type, $ar1))
						{
							echo 'checked="checked"/>';
						}
						else
							echo '/>';

						echo $post_type.'<br/>';

					}
					if($cnt==0)
						echo 'NA';
					?>
					</td>
				</tr>



				<tr valign="top" id="xyz_smap">

					<td  colspan="1">Enable credit link to author
					</td>
					<td><select name="xyz_credit_link" id="xyz_smap_credit_link">

							<option value="smap"
							<?php if($xyz_credit_link=='smap') echo 'selected'; ?>>Yes</option>

							<option
								value="<?php echo $xyz_credit_link!='smap'?$xyz_credit_link:0;?>"
								<?php if($xyz_credit_link!='smap') echo 'selected'; ?>>No</option>
					</select>
					</td>
				</tr>


				<tr>

					<td id="bottomBorderNone">
							

					</td>

					
<td id="bottomBorderNone">
<input type="submit" class="submit_smap_new"				style="margin-top: 10px;"					value=" Update Settings" name="bsettngs" /></td>
				</tr>


			</table>
		</form>
		
		
</div>		

	<script type="text/javascript">
var catval='<?php echo $xyz_smap_include_categories; ?>';
var custtypeval='<?php echo $xyz_smap_include_customposttypes; ?>';
jQuery(document).ready(function() {
	  if(catval=="All")
		  jQuery("#cat_dropdown_span").hide();
	  else
		  jQuery("#cat_dropdown_span").show();

	}); 
	
function setcat(obj)
{
var sel_str="";
for(k=0;k<obj.options.length;k++)
{
if(obj.options[k].selected)
sel_str+=obj.options[k].value+",";
}


var l = sel_str.length; 
var lastChar = sel_str.substring(l-1, l); 
if (lastChar == ",") { 
	sel_str = sel_str.substring(0, l-1);
}

document.getElementById('xyz_smap_sel_cat').value=sel_str;

}

var d1='<?php echo $xyz_smap_include_categories;?>';
splitText = d1.split(",");
jQuery.each(splitText, function(k,v) {
jQuery("#xyz_smap_catlist").children("option[value="+v+"]").attr("selected","selected");
});

function rd_cat_chn(val,act)
{//xyz_smap_cat_all xyz_smap_cust_all 
	if(val==1)
	{
		if(act==-1)
		  jQuery("#cat_dropdown_span").hide();
		else
		  jQuery("#cat_dropdown_span").show();
	}
	
}
</script>
	<?php 
?>