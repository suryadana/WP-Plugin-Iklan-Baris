<?php

defined('ABSPATH') or die("Fuck accessing!");

function iklan_baris_render_submenu_page(){
	global $wpdb;
	$table_content = $wpdb->prefix . "iklan_baris_content";
	$table_name_access = $wpdb->prefix . "iklan_baris_access";
    $currnet_user = wp_get_current_user();
    $username = $currnet_user->user_login;
    $email = $currnet_user->user_email;
    $api_link = get_home_url()."/api";
    $api_key = base64_encode(sha1($username) . "%" . sha1($email));

    $wpdb->get_results("SELECT * FROM ". $table_name_access . " WHERE api_key = '". $api_key ."'");
    if($wpdb->num_rows === 0){
    	$wpdb->insert($table_name_access, 
        array(
        	"api_link" => $api_link,
            "api_key" => $api_key,
            ));
    }
	if($_POST["submit"] == "Add Iklan"){
		if(strlen($_POST["title-iklan-baris"]) != 0){
			if(strlen($_POST['link-iklan-baris']) != 0){
				if(strlen($_POST['description-iklan-baris']) != 0){
					$wpdb->insert($table_content, 
						array(
							"content_title" => $_POST["title-iklan-baris"],
							"content_link" => $_POST["link-iklan-baris"],
							"content_description" => $_POST["description-iklan-baris"],
						));
					wp_redirect(get_home_url()."/wp-admin/themes.php?page=iklan-baris.php");
				}
			}
		}
	}
	?>
	<div class="wrap-iklan-baris">
		<h2 class="title-iklan-baris">
			<?php _e("Iklan Baris", "iklan-baris");?>
		</h2>
		<div class="row">
			<div class="col-sm-4">
				<div class="container-fluid">
					<div class="wrap-acess">
						<div class="content">
							<div class="row" style="margin-left: 1px;">
							<h3>Acess Manage</h3>
								<?php 
								$api_key = base64_encode(sha1($username) . "%" . sha1($email));
								$apis = $wpdb->get_results("SELECT * FROM ". $table_name_access ." WHERE api_key = '". $api_key."'");
								if($wpdb->num_rows > 0){
									foreach ($apis as $api) {
									?>
										<div class="col-sm-12">
											<h4>Url API : </h4> <a href="<?php echo $api->api_link;?>"><?php echo $api->api_link;?></a>
										</div>
										<div class="col-sm-12">
											<h4>API Key : </h4> <textarea name="api_key" id="api_key" cols="40" rows="5" disabled><?php echo $api->api_key;?></textarea>
										</div>
									<?php
									}
								}else{
									?>
										<div class="col-sm-12">
											<h4>Api aceess not found please change to another account.</h4>
										</div>
									<?php
								}
								?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="container-fluid">
					<div class="wrap-content">
						<div class="content">
							<h3>Content Manage</h3>
							<form action="" role="form" method="post">
								<div class="form-group">
									<label for="title">Title Iklan</label>
									<input class="form-control" type="text" name="title-iklan-baris">
								</div>
								<div class="form-group">
									<label for="link">Link Iklan</label>
									<input class="form-control" type="text" name="link-iklan-baris">
								</div>
								<div class="form-group">
									<label for="description">Description Iklan</label>
									<textarea class="form-control" name="description-iklan-baris" id="description-iklan-baris" cols="30" rows="10"></textarea>
								</div>
								<?php submit_button( __( 'Add Iklan', 'iklan-baris' ), 'primary', 'submit', true ); ?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="box" style="padding: 2px;margin-top: 10px;padding-left: 15px;padding-right: 15px;">
					<div class="box-header with-border">
						<h3>Data Iklan</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th style="widht:24px">#</th>
									<th>Title</th>
									<th>Link</th>
									<th>Description</th>
								</tr>
								<?php 
								$data_iklan = $wpdb->get_results("SELECT * FROM $table_content ORDER BY id_content DESC"); 
								// var_dump($data_iklan);
								$no = 1;
								foreach ($data_iklan as $data) { ?>
									<tr>
										<td style="widht:24px"><?php echo $no;?></td>
										<td><?php echo $data->content_title;?></td>
										<td><?php echo $data->content_link;?></td>
										<td><?php echo $data->content_description;?></td>
									</tr>
								<?php $no++; } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}