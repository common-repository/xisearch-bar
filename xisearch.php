<?php
/*
Plugin Name: XiSearch bar
Plugin URI: http://www.xisearch.com
Description: XiSearch smart search plugin. Enrich your website content with toolbar and/or content hint that bring an additional useful information using search on the site and in the Web, search images and video, Wiki and text translator. Get the script from the <a href="http://www.xisearch.com">http://www.xisearch.com</a> or use Express setting to choose your style of XiSearch bar and content hint.
Version: 2.6
Author: XiSearch
*/

if( !is_admin() ) {
	add_action('wp_print_scripts', 'xisearch_setup');
}
add_action('admin_menu', 'xisearch_config_menu');

function xisearch_setup() {
	$xisearchScriptPath = get_option('XiSearchScriptPath');
	$xisearchSettingsType = get_option('XiSearchSettingType');
	
	$xisearchBarPosition = get_option('XiSearchBarPosition');
	$xisearchTheme = get_option('XiSearchTheme');
	$xisearchLanguage = get_option('XiSearchLanguage');
	$xisearchBarType = get_option('XiSearchBarType');
	
	if ($xisearchScriptPath != '') {
		wp_enqueue_script('XiSearchBar', $xisearchScriptPath, false, false, true );
	}
	else{
		wp_enqueue_script('XiSearchBar', "http://ms.xisearch.com/bars/default_loader.js", false, false, true );
	}
}

function xisearch_config_menu() {
	add_submenu_page('themes.php', __('XiSearch Configuration'), __('XiSearch Configuration'), 'manage_options', 'xisearch-key-config', 'xisearch_configuration');
}

function xisearch_configuration() {
	$xisearchScriptPath = get_option('XiSearchScriptPath');

	if ( isset($_POST['submit']) ) {
		if($_POST['xiInstallType'] == 0)
		{
			$xisearchSettingsType = 0;
			if (isset($_POST['xisearchbarpath']))
			{
				$xisearchScriptPath =  $_POST['xisearchbarpath'];
				
			}
			else
			{
				$xisearchScriptPath = "http://ms.xisearch.com/bars/default_loader.js";
			}
		}
		else
		{
			$xisearchSettingsType = 1;
			$xisearchScriptPath = "http://ms.xisearch.com/bars/";
			
		
			if($_POST['xisearchtheme'] == 0) $xisearchScriptPath.="bb";
			else if($_POST['xisearchtheme'] == 1) $xisearchScriptPath.="gray";
			else if($_POST['xisearchtheme'] == 2) $xisearchScriptPath.="green";
			else if($_POST['xisearchtheme'] == 3) $xisearchScriptPath.="red";
			$xisearchTheme = $_POST['xisearchtheme'];
			update_option('XiSearchTheme', $xisearchTheme);
			
		
			if($_POST['xisearchbarposition'] == 0) $xisearchScriptPath.="top";
			else $xisearchScriptPath.="bottom";
			
			$xisearchBarPosition = $_POST['xisearchbarposition'];
			update_option('XiSearchBarPosition', $xisearchBarPosition);
			

			if($_POST['xisearchLanguage'] == 0) $xisearchScriptPath.="en";
			else if($_POST['xisearchLanguage'] == 1) $xisearchScriptPath.="esp";
			else if($_POST['xisearchLanguage'] == 2) $xisearchScriptPath.="de";
			else if($_POST['xisearchLanguage'] == 3) $xisearchScriptPath.="ru";
			
			$xisearchLanguage = $_POST['xisearchLanguage'];
			update_option('XiSearchLanguage', $xisearchLanguage);
			
			if($_POST['xisearchBarType'] == 0) $xisearchScriptPath.="";
			else if($_POST['xisearchBarType'] == 1) $xisearchScriptPath.="2";
			
			$xisearchBarType = $_POST['xisearchBarType'];
			update_option('XiSearchBarType', $xisearchBarType);
			
			$xisearchScriptPath.=".js";
		
		}

		update_option('XiSearchSettingType', $xisearchSettingsType);
		update_option('XiSearchScriptPath', $xisearchScriptPath);
		echo "<div id=\"updatemessage\" class=\"updated fade\"><p>XiSearch bar settings updated.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";	
	}
	?>
	<div class="wrap">
		<h2>XiSearch bar configuration for WordPress</h2>
		<div class="postbox-container">
			<div class="metabox-holder">	
				<div class="meta-box-sortables">
					<form action="" method="post" id="xisearch_configuration">
					<div id="xisearch_settings" class="postbox">
						<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class="hndle"><span>XiSearch Settings</span></h3>
						<div class="inside">
						<br />
						<fieldset >
						<legend><input type="radio" name="xiInstallType" value="0" <?php  if($xisearchSettingsType==0) echo "checked='checked'"; ?> onclick="if(this.checked) xiChangeSettingType(0);">Script with full details</input></legend>

							<table id="xisearchtbl1" class="form-table" <?php  if($xisearchSettingsType==1) echo "disabled='true'"; ?>>
								<tr><th valign="top" scrope="row"><label for="xisearchbarpath">XiSearch script for Wordpress:</label></th>
								<td valign="top"><input id="xisearchbarpath" name="xisearchbarpath" type="text" size="80" value="<?php echo $xisearchScriptPath; ?>"/></td></tr>
							</table>
							</fieldset>
							<br />
						<fieldset >
						<legend><input type="radio" name="xiInstallType" value="1" <?php  if($xisearchSettingsType==1) echo "checked='checked'"; ?> onclick="if(this.checked) xiChangeSettingType(1);">Express settings</input></legend>
							<table  id="xisearchtbl2"class="form-table" <?php  if($xisearchSettingsType==0) echo "disabled='true'"; ?>>
								<tr><th valign="top" scrope="row"><label for="xisearchbarposition1">Bar position:</label></th>
								<td valign="top"><input name="xisearchbarposition" value="0" type="radio" <?php if($xisearchBarPosition==0) echo "checked='checked'"; ?>>Top</input></td>
								<td valign="top"><input name="xisearchbarposition" value="1" type="radio" <?php if($xisearchBarPosition==1) echo "checked='checked'"; ?>>Bottom</input></td>
								<td valign="top" style="font-size:12px;font-style:italic;">You have to <a href="http://www.xisearch.com" target="_blank">register</a> to select another position </td></tr>
							</table>
							<table id="xisearchtbl3" class="form-table" <?php  if($xisearchSettingsType==0) echo "disabled='true'"; ?>>
								<tr><th valign="top" scrope="row"><label for="xisearchbarposition1">Theme:</label></th>
								<td valign="top"><input name="xisearchtheme" type="radio" value="0" style="float:left;margin-top:15px;" <?php  if($xisearchTheme==0) echo "checked='checked'"; ?>></input>
								<div style="height:40px;width:65px;float:left;">
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/blackbluetheme/lback.png);float:left;"></div>
								<div style="height:40px;width:50px;background-image:url(http://cdn.xisearch.com/blackbluetheme/mback.png);float:left;"></div>
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/blackbluetheme/rback.png);float:left;"></div>
								</div>
								
								
								</td>
								<td valign="top"><input name="xisearchtheme" type="radio" value="1" style="float:left;margin-top:15px;" <?php  if($xisearchTheme==1) echo "checked='checked'"; ?>></input>
								<div style="height:40px;width:65px;float:left;">
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/gray1theme/lback.png);float:left;"></div>
								<div style="height:40px;width:50px;background-image:url(http://cdn.xisearch.com/gray1theme/mback.png);float:left;"></div>
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/gray1theme/rback.png);float:left;"></div>
								</div>
								</td>
								<td valign="top" style="font-size:12px;font-style:italic;">You have to <a href="http://www.xisearch.com" target="_blank">register</a> to select one of the 42 other themes</td></tr>
								<tr><td></td>
								<td>
								<input name="xisearchtheme" type="radio" value="2" style="float:left;margin-top:15px;" <?php  if($xisearchTheme==2) echo "checked='checked'"; ?>></input>
								<div style="height:40px;width:65px;float:left;">
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/green1theme/lback.png);float:left;"></div>
								<div style="height:40px;width:50px;background-image:url(http://cdn.xisearch.com/green1theme/mback.png);float:left;"></div>
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/green1theme/rback.png);float:left;"></div>
								</div>
								</td><td colspan="2">
								<input name="xisearchtheme" type="radio" value="3" style="float:left;margin-top:15px;" <?php  if($xisearchTheme==3) echo "checked='checked'"; ?>></input>
								<div style="height:40px;width:65px;float:left;">
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/red1theme/lback.png);float:left;"></div>
								<div style="height:40px;width:50px;background-image:url(http://cdn.xisearch.com/red1theme/mback.png);float:left;"></div>
								<div style="height:40px;width:5px;background-image:url(http://cdn.xisearch.com/red1theme/rback.png);float:left;"></div>
								</div>								
								</td></tr>
							</table>
							<table id="xisearchtbl4" class="form-table" <?php  if($xisearchSettingsType==0) echo "disabled='true'"; ?>>
								<tr><th valign="top" scrope="row"><label for="xisearchbarposition1">Language:</label></th>
								<td valign="top">
								<input type="radio" name="xisearchLanguage" value="0" <?php  if($xisearchLanguage==0) echo "checked='checked'"; ?>><img src="http://cdn.xisearch.com/flags/us.png" title="English"/></input>&nbsp;&nbsp;
								<input type="radio" name="xisearchLanguage" value="1" <?php  if($xisearchLanguage==1) echo "checked='checked'"; ?>><img src="http://cdn.xisearch.com/flags/es.png" title="Spanish"/></input>&nbsp;&nbsp;
								<input type="radio" name="xisearchLanguage" value="2" <?php  if($xisearchLanguage==2) echo "checked='checked'"; ?>><img src="http://cdn.xisearch.com/flags/de.png" title="German"/></input>&nbsp;&nbsp;
								<input type="radio" name="xisearchLanguage" value="3" <?php  if($xisearchLanguage==3) echo "checked='checked'"; ?>><img src="http://cdn.xisearch.com/flags/ru.png" title="Russian"/></input>
								</td>
								<td valign="top" style="font-size:12px;font-style:italic;">You have to <a href="http://www.xisearch.com" target="_blank">register</a> to select another language</td></tr>
							</table>
							<table id="xisearchtbl5" class="form-table" <?php  if($xisearchSettingsType==0) echo "disabled='true'"; ?>>
								<tr><th valign="top" scrope="row"><label for="xisearchbartye1">XiSearch tools set:</label></th>
								<td valign="top">
								<input type="radio" name="xisearchBarType" value="0" <?php  if($xisearchBarType==0) echo "checked='checked'"; ?>>Bar + Content hint</input>&nbsp;&nbsp;
								<input type="radio" name="xisearchBarType" value="1" <?php  if($xisearchBarType==1) echo "checked='checked'"; ?>>Only Content hint</input>&nbsp;&nbsp;
								</td>
								<td valign="top" style="font-size:12px;font-style:italic;">You have to <a href="http://www.xisearch.com" target="_blank">register</a> to select another language</td></tr>
							</table>
						</fieldset>
						<br />
						</div>
					</div>
					<div class="submit"><input type="submit" class="button-primary" name="submit" value="Update XiSearch bar settings &raquo;" /></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	function xiChangeSettingType(i)
	{
		if(i==0) 
		{
			jQuery("#xisearchtbl2").attr("disabled", true);
			jQuery("#xisearchtbl3").attr("disabled", true);
			jQuery("#xisearchtbl4").attr("disabled", true);
			jQuery("#xisearchtbl5").attr("disabled", true);
			jQuery("#xisearchtbl1").removeAttr("disabled");
		}
		else
		{
		jQuery("#xisearchtbl1").attr("disabled", true);
		jQuery("#xisearchtbl2").removeAttr("disabled");
		jQuery("#xisearchtbl3").removeAttr("disabled");
		jQuery("#xisearchtbl4").removeAttr("disabled");
		jQuery("#xisearchtbl5").removeAttr("disabled");
		}
	}
	</script>
	<?php
} 
?>