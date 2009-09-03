<?php
include "functionapi.php";
if ($_SESSION['user_class'] == null){
die("place relogin<a href ='login.php'>login page</a>");
}
switch($_REQUEST['active']){
	case "deltemplate":
	$res = $dbconnect->query("delete from templates where template_name='".$_POST['template_name']."'");
	is_error($res);
	$template_path_file="template/".$_POST['template_name'];
	exec("rm -f ".$template_path_file);
	if(is_file($template_path_file)){
	$header_info="location: commitconf.php?uptemplate_error=4";
	header($header_info);
	}else{
	$header_info="location: commitconf.php";
	header($header_info);
	}
	case "commit_config":
	if(isset($_POST['commit_all'])){
	$commit_service_res = $dbconnect->query("select * from services where status=1");
	is_error($commit_service_res);
		if($commit_service_res->numRows() == 0){
		$header_info="location: commitconf.php?commit_error=1";
        	header($header_info);
		}
		while($service_info = $commit_service_res->fetchRow(DB_FETCHMODE_ASSOC)){
		$commit_nginx_config_content="";
		$server_commit_array=array();
		$service_config_path=$_CONF['conf_dir'].$service_info['serverip']."/";
		$service_name = $service_info['serverip'];
			if(!is_dir($service_config_path)){
			mkdir($service_config_path);
			}
		$server_commit_array=array($service_info['domain_name']);
		//write nginx service config file path
		$service_config_file=$service_config_path.$service_info['conf_name'].".vservice";
		//upstream config content
		$upstream_name_res = $dbconnect->query("select DISTINCT upstream_name from upstreams where service_id=".$service_info['id']);
		is_error($upstream_name_res);
			if($upstream_name_res->numRows() > 0){
			$template_upstream_file="template/".$_POST['template_upstream'];
			$template_upstream_buffer=template_read($template_upstream_file);	
				while ($upstream_name_info = $upstream_name_res->fetchRow()){
				$upstream_commit_arrary = array();
				array_push($upstream_commit_arrary,$upstream_name_info['0']);
				$commit_upstream_real_server_res = $dbconnect->query("select * from upstreams where service_id=".$service_info['id']." and upstream_name='".$upstream_name_info['0']."'");
				is_error($commit_upstream_real_server_res);
					$commit_upstream_server = "";
					while($commit_upstream_server_info = $commit_upstream_real_server_res->fetchRow(DB_FETCHMODE_ASSOC)){
					$commit_upstream_server .= "\n server ".$commit_upstream_server_info['real_server']." ".$commit_upstream_server_info['options']." ;\n";
					}
				array_push($upstream_commit_arrary,$commit_upstream_server);
				$commit_upstream_content .= preg_replace($upstream_commit_command,$upstream_commit_arrary,$template_upstream_buffer);
				}
		
			}
		//location config content
		$commit_location_info_res = $dbconnect->query("select * from locations where service_id=".$service_info['id']);
		is_error($commit_location_info_res);
		$commit_location_contect="";
		while($commit_location_info = $commit_location_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
		$commit_rewirtes_contect="";
		$commit_rewirtes_info_res = $dbconnect->query("select DISTINCT comments from rewrites_in_location where location_id=".$commit_location_info['id']);
		is_error($commit_rewirtes_info_res);
		if($commit_rewirtes_info_res->numRows() == 0){
		$commit_rewirtes_contect="";
		}else{
			while($commit_rewirtes_info = $commit_rewirtes_info_res->fetchRow()){
			$commit_rewirtes_res = $dbconnect->query("select * from rewrites where comments='".$commit_rewirtes_info[0]."'");
			is_error($commit_rewirtes_res);
				$rewrite_policy_contect="";
				$rewrite_policy_protasis="";
				while($commit_rewirtes = $commit_rewirtes_res->fetchRow(DB_FETCHMODE_ASSOC)){
				$rewrite_policy_contect.="\t".$commit_rewirtes['method'].";\n";
				$rewrite_policy_protasis=$commit_rewirtes['protasis'];
				}
			if($rewrite_policy_protasis == null){
			$commit_rewirtes_contect.=$rewrite_policy_contect;	
			}else{
			$commit_rewirtes_contect.= "if (".$rewrite_policy_protasis.") { \n".
			$rewrite_policy_contect."\t}\n";
			}
			}
		}
		$template_location_file="template/".$_POST['template_location'];
		$template_location_buffer=template_read($template_location_file);
		$location_commit_array=array();
		array_push($location_commit_array,$commit_location_info['location_path'],$commit_location_info['alias'],$commit_location_info['root_path'],$commit_location_info['proxy_pass'],$commit_location_info['proxy_next_upstream'],$commit_location_info['access_log'],$commit_rewirtes_contect);
		$commit_location_contect .= preg_replace($location_commit_command,$location_commit_array,$template_location_buffer);		
		}
		$template_server_file="template/server.template";
		$template_server_buffer=template_read($template_server_file);
		$template_server_buffer=preg_replace("/}/","",$template_server_buffer);
		$commit_server_contect=preg_replace($server_commit_comand,$server_commit_array,$template_server_buffer);
		$commit_nginx_config_content=$commit_upstream_content.$commit_server_contect.$commit_location_contect." }\n";				
		if(commit_config_write($service_config_file,$commit_nginx_config_content)){
		if(commit_log(time(),$service_name,$service_config_file,$_CONF['commit_log']) == false){
                die("commit file is ok,write log error!!");
                }
		//clear upstrea content
		$commit_upstream_content = "";
		$md5_code=md5_file($_CONF['commit_log']);
		if(md5file_write($md5_code,$_CONF['md5_file']) == false){
		die("write md5_file error!!");
		}
		upserivce_status(2,$service_info['id']);
		$header_info="location: services.php";
		header($header_info);
		}else{
		$header_info="location: commitconf.php?commit_error=2";
		header($header_info);
		}	
		}	
	}else{
	$res = $dbconnect->query("select * from services where id=".$_POST['service_id']);
	is_error($res);
	$service_info = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$commit_nginx_config_content="";
        $server_commit_array=array();
        $service_config_path=$_CONF['conf_dir'].$service_info['serverip']."/";
        $service_name = $service_info['serverip'];
        	if(!is_dir($service_config_path)){
                mkdir($service_config_path);
                }
        $server_commit_array=array($service_info['domain_name']);
	$service_config_file=$service_config_path.$service_info['conf_name'].".vservice";
	$upstream_name_res = $dbconnect->query("select DISTINCT upstream_name from upstreams where service_id=".$service_info['id']);
                is_error($upstream_name_res);
                        if($upstream_name_res->numRows() > 0){
                        $template_upstream_file="template/".$_POST['template_upstream'];
                        $template_upstream_buffer=template_read($template_upstream_file);
                                while ($upstream_name_info = $upstream_name_res->fetchRow()){
                                $upstream_commit_arrary = array();
                                array_push($upstream_commit_arrary,$upstream_name_info['0']);
                                $commit_upstream_real_server_res = $dbconnect->query("select * from upstreams where service_id=".$service_info['id']." and upstream_name='".$upstream_name_info['0']."'");
                                is_error($commit_upstream_real_server_res);
                                        $commit_upstream_server ="";
                                        while($commit_upstream_server_info = $commit_upstream_real_server_res->fetchRow(DB_FETCHMODE_ASSOC)){
                                        $commit_upstream_server .= "\n server ".$commit_upstream_server_info['real_server']." ".$commit_upstream_server_info['options']." ;\n";
                                        }
                                array_push($upstream_commit_arrary,$commit_upstream_server);
                                $commit_upstream_content .= preg_replace($upstream_commit_command,$upstream_commit_arrary,$template_upstream_buffer);
                                }
                        }
	//location config content
                $commit_location_info_res = $dbconnect->query("select * from locations where service_id=".$service_info['id']);
                is_error($commit_location_info_res);
                $commit_location_contect="";
                while($commit_location_info = $commit_location_info_res->fetchRow(DB_FETCHMODE_ASSOC)){
                $commit_rewirtes_contect="";
                $commit_rewirtes_info_res = $dbconnect->query("select DISTINCT comments from rewrites_in_location where location_id=".$commit_location_info['id']);
                is_error($commit_rewirtes_info_res);
                if($commit_rewirtes_info_res->numRows() == 0){
                $commit_rewirtes_contect="";
                }else{
                        while($commit_rewirtes_info = $commit_rewirtes_info_res->fetchRow()){
                        $commit_rewirtes_res = $dbconnect->query("select * from rewrites where comments='".$commit_rewirtes_info[0]."'");
                        is_error($commit_rewirtes_res);
                                $rewrite_policy_contect="";
				$rewrite_policy_protasis="";
                                while($commit_rewirtes = $commit_rewirtes_res->fetchRow(DB_FETCHMODE_ASSOC)){
                                $rewrite_policy_contect.="\t".$commit_rewirtes['method'].";\n";
                                $rewrite_policy_protasis=$commit_rewirtes['protasis'];
                                }
                        if($rewrite_policy_protasis == null){
                        $commit_rewirtes_contect.=$rewrite_policy_contect;
                        }else{
                        $commit_rewirtes_contect.= "if (".$rewrite_policy_protasis.") { \n".
                        $rewrite_policy_contect."\t}\n";
                        }
                        }
                }
                $template_location_file="template/".$_POST['template_location'];
                $template_location_buffer=template_read($template_location_file);
                $location_commit_array=array();
                array_push($location_commit_array,$commit_location_info['location_path'],$commit_location_info['alias'],$commit_location_info['root_path'],$commit_location_info['proxy_pass'],$commit_location_info['proxy_next_upstream'],$commit_location_info['access_log'],$commit_rewirtes_contect);
                $commit_location_contect .= preg_replace($location_commit_command,$location_commit_array,$template_location_buffer);
                }
                $template_server_file="template/server.template";
                $template_server_buffer=template_read($template_server_file);
                $template_server_buffer=preg_replace("/}/","",$template_server_buffer);
                $commit_server_contect=preg_replace($server_commit_comand,$server_commit_array,$template_server_buffer);
                $commit_nginx_config_content=$commit_upstream_content.$commit_server_contect.$commit_location_contect." }\n";
                if(commit_config_write($service_config_file,$commit_nginx_config_content)){
                if(commit_log(time(),$service_name,$service_config_file,$_CONF['commit_log']) == false){
                die("commit file is ok,write log error!!");
                }
		$md5_code=md5_file($_CONF['commit_log']);
                if(md5file_write($md5_code,$_CONF['md5_file']) == false){
                die("write md5_file error!!");
                }
		upserivce_status(2,$service_info['id']);	
                $header_info="location: services.php";
                header($header_info);
                }else{
                $header_info="location: commitconf.php?commit_error=2";
                header($header_info);
                }
	}
	
	

}
?>
