<?php 
defined('ABSPATH') or die("Fuck accessing!");

/**
* Create route for access to api url
*/
function create_routes($router){
	$router->add_route('api', array(
        'path' => 'api',
        'access_callback' => true,
        'page_callback' => 'api_func',
        'template' => false,
    ));
}
add_action( 'wp_router_generate_routes', 'create_routes' );


/**
* Api function for auth and post data
*/
function api_func(){
	global $wpdb;
	$table_access = $wpdb->prefix . "iklan_baris_access";
	$table_name_content = $wpdb->prefix . "iklan_baris_content";
	header('Content-Type: application/json');
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(count($_POST) !== 0){
			if($_POST['auth_key'] !== ""){
				$wpdb->get_results("SELECT * FROM " . $table_access . " WHERE api_key = '" . $_POST['auth_key'] . "'");
				if($wpdb->num_rows > 0){
					if($_POST['title-iklan-baris'] !== "" && $_POST['title-iklan-baris'] !== NULL && $_POST['link-iklan-baris'] !== "" && $_POST['link-iklan-baris'] !== NULL && $_POST['description-iklan-baris'] !== "" && $_POST['description-iklan-baris'] !== NULL){
						$insert_status = $wpdb->insert($table_name_content, array(
								"content_title" => $_POST["title-iklan-baris"],
								"content_link" => $_POST["link-iklan-baris"],
								"content_description" => $_POST["description-iklan-baris"],
								));
						if($insert_status){
							$data = array("status" => 200, "message" => "Post data success.");
							echo json_encode($data);
						}else{
							$data = array("status" => 212, "message" => "Post data failed");
							echo json_encode($data);
						}
					}else{
						$data = array("status" => 404, "message" => "Please input 'content_title', 'content_link', 'content_description'.");
						echo json_encode($data);
					}
				}else{
					$data = array("status" => 1337, "message" => "Authentication Key failed.");
					echo json_encode($data);
				}
			}else{
				$data = array("status" => 404, "message" => "Please input 'auth_key'.");
				echo json_encode($data);
			}
		}else{
			$data = array("status" => 404, "message" => "Please input 'auth_key'.");
			echo json_encode($data);
		}
	}else{
		$data = array("status" => 404, "message" => "Please use method POST.");
		echo json_encode($data);
	}
}
?>