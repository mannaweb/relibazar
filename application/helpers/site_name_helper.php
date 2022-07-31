<?php
if(!function_exists('site_name')){ 
 function site_name(){    
 	$ci = @get_instance();
    $ci->load->database();
    $ci->db->select('title');
    $ci->db->from('site_settings');
    $ci->db->where('id','1');
    $query = $ci->db->get();
    $row = $query->row();
    $result = array();
    $site_name ='';
    if(isset($row->title) && !empty($row->title)){
        $site_name = $row->title;
    }else{
        $site_name = 'Livo';
    }
    return $site_name;
 }  
}
?>