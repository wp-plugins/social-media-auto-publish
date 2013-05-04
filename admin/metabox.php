<?php 


add_action( 'add_meta_boxes', 'xyz_smap_add_custom_box' );
function xyz_smap_add_custom_box()
{
	$posttype="";
	if(isset($_GET['post_type']))
	$posttype=$_GET['post_type'];
	
	if(isset($_GET['action']) && $_GET['action']=="edit")
	return ;

	if($posttype=="")
		$posttype="post";

	if ($posttype=="page")
	{

		$xyz_smap_include_pages=get_option('xyz_smap_include_pages');
		if($xyz_smap_include_pages==0)
			return;
	}
	else if($posttype!="post")
	{

		$xyz_smap_include_customposttypes=get_option('xyz_smap_include_customposttypes');


		$carr=explode(',', $xyz_smap_include_customposttypes);
		if(!in_array($posttype,$carr))
			return;

	}

	add_meta_box( "xyz_smap", '<strong>Social Media Auto Publish - Post Options</strong>', 'xyz_smap_addpostmetatags') ;
}

function xyz_smap_addpostmetatags()
{
	$imgpath= plugins_url()."/social-media-auto-publish/admin/images/";
	$heimg=$imgpath."support.png";
	?>
<script>
var fcheckid;
var tcheckid;
var lcheckid;
function displaycheck()
{
fcheckid=document.getElementById("xyz_smap_post_permission").value;
if(fcheckid==1)
{
	document.getElementById("fpmd").style.display='';	
	document.getElementById("fpmf").style.display='';	
}
else
{
	document.getElementById("fpmd").style.display='none';	
	document.getElementById("fpmf").style.display='none';	
}
tcheckid=document.getElementById("xyz_smap_twpost_permission").value;
if(tcheckid==1)
{

	document.getElementById("twmf").style.display='';
	document.getElementById("twai").style.display='';	
}
else
{
	
	document.getElementById("twmf").style.display='none';
	document.getElementById("twai").style.display='none';		
}

lcheckid=document.getElementById("xyz_smap_lnpost_permission").value;
if(lcheckid==1)
{

	
    document.getElementById("lnimg").style.display='';
	document.getElementById("lnmf").style.display='';	
	document.getElementById("shareprivate").style.display='';	
}
else
{
    document.getElementById("lnimg").style.display='none';
	document.getElementById("lnmf").style.display='none';	
	document.getElementById("shareprivate").style.display='none';		
}

}


</script>
<script type="text/javascript">
function detdisplay(id)
{
	document.getElementById(id).style.display='';
}
function dethide(id)
{
	document.getElementById(id).style.display='none';
}

function drpdisplay()
{
	var shmethod= document.getElementById('xyz_smap_ln_sharingmethod').value;
	if(shmethod==1)	
	{
		document.getElementById('shareprivate').style.display="none";
	}
	else
	{
		document.getElementById('shareprivate').style.display="";
	}
}

</script>
<table>
	<tr valign="top">
		<td>Enable auto publish post to my facebook account
		</td>
		<td><select id="xyz_smap_post_permission" name="xyz_smap_post_permission"
			onchange="displaycheck()"><option value="0"
			<?php  if(get_option('xyz_smap_post_prmission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_post_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	<tr valign="top" id="fpmd">
		<td>Posting method
		</td>
		<td><select id="xyz_smap_po_method" name="xyz_smap_po_method">
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
	<tr valign="top" id="fpmf">
		<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_fb')" onmouseout="dethide('xyz_fb')">
						<div id="xyz_fb" class="informationdiv" style="display: none;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.
						</div>
		</td>
		<td>
		<textarea id="xyz_smap_message" name="xyz_smap_message"><?php echo get_option('xyz_smap_message');?></textarea>
		</td>
	</tr>
	
	<tr valign="top">
		<td>Enable auto publish	posts to my twitter account
		</td>
		<td><select id="xyz_smap_twpost_permission" name="xyz_smap_twpost_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_twpost_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_twpost_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="twai">
		<td>Attach image to twitter post
		</td>
		<td><select id="xyz_smap_twpost_image_permission" name="xyz_smap_twpost_image_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_twpost_image_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_twpost_image_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="twmf">
		<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_tw')" onmouseout="dethide('xyz_tw')">
						<div id="xyz_tw" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.
						</div>
		</td>
		<td>
		<textarea id="xyz_smap_twmessage" name="xyz_smap_twmessage"><?php echo get_option('xyz_smap_twmessage');?></textarea>
		</td>
	</tr>
	
	<tr valign="top">
		<td>Enable auto publish	posts to my linkedin account
		</td>
		<td><select id="xyz_smap_lnpost_permission" name="xyz_smap_lnpost_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_lnpost_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_lnpost_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="lnimg">
		<td>Attach image to linkedin post
		</td>
		<td><select id="xyz_smap_lnpost_image_permission" name="xyz_smap_lnpost_image_permission"
			onchange="displaycheck()">
				<option value="0"
				<?php  if(get_option('xyz_smap_lnpost_image_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_smap_lnpost_image_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="shareprivate">
	<input type="hidden" name="xyz_smap_ln_sharingmethod" id="xyz_smap_ln_sharingmethod" value="0">
	<td>Share post content with</td>
	<td>
		<select id="xyz_smap_ln_shareprivate" name="xyz_smap_ln_shareprivate" >
		 <option value="0" <?php  if(get_option('xyz_smap_ln_shareprivate')==0) echo 'selected';?>>
Public</option><option value="1" <?php  if(get_option('xyz_smap_ln_shareprivate')==1) echo 'selected';?>>Connections only</option></select>
	</td></tr>

	<tr valign="top" id="lnmf">
		<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_ln')" onmouseout="dethide('xyz_ln')">
						<div id="xyz_ln" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.
						</div>
		</td>
		<td>
		<textarea id="xyz_smap_lnmessage" name="xyz_smap_lnmessage"><?php echo get_option('xyz_smap_lnmessage');?></textarea>
		</td>
	</tr>
	
</table>
<script type="text/javascript">
	displaycheck();
	</script>
<?php 
}
?>