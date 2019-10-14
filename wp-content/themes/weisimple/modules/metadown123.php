<?php

//防盗码
function getRandPass($length = 6){
 $password = '';
 $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
 $char_len = strlen($chars); 
 for($i=0;$i<$length;$i++){
 $loop = mt_rand(0, ($char_len-1));
 $password .= $chars[$loop];
 }
 return $password;
}

class down_box{   
    var $options;   
    var $boxinfo;   
       
    //构造函数   
    function down_box($options,$boxinfo){   
        $this->options = $options;   
        $this->boxinfo = $boxinfo;   
           
        add_action('admin_menu', array(&$this, 'init_boxes'));   
        add_action('save_post', array(&$this, 'save_postdata'));   
    }   
       
    //初始化   
    function init_boxes(){   
        //$this->add_script_and_styles();   
        $this->or_create_down_box();   
    }   
       
 
       
    /*************************/  
    function add_hijack_var()   
    {   
        echo "<meta name='hijack_target' content='".$_GET['hijack_target']."' />\n";   
    }   
       
    //创建自定义面板   
    function or_create_down_box(){   
        if ( function_exists('add_meta_box') && is_array($this->boxinfo['page']) )    
        {   
            foreach ($this->boxinfo['page'] as $area)   
            {      
                if ($this->boxinfo['callback'] == '') $this->boxinfo['callback'] = 'new_meta_boxes';   
                   
                add_meta_box(      
                    $this->boxinfo['id'],    
                    $this->boxinfo['title'],   
                    array(&$this, $this->boxinfo['callback']),   
                    $area, $this->boxinfo['context'],    
                    $this->boxinfo['priority']   
                );     
            }   
        }     
    }   
       
    //创建自定义面板的显示函数   
    function new_meta_boxes(){   
        global $post;   
        //根据类型调用显示函数   
        foreach ($this->options as $option)   
        {                  
            if (method_exists($this, $option['type']))   
            {   
                $meta_box_value = get_post_meta(get_the_ID(), $option['id'], true);    
                if($meta_box_value != "") $option['std'] = $meta_box_value;     
                   
                echo '<div class="alt kriesi_meta_box_alt meta_box_'.$option['type'].' meta_box_'.$this->boxinfo['context'].'">';   
                $this->$option['type']($option);   
                echo '</div>';   
            }   
        }   
           
        //隐藏域   
        echo'<input type="hidden" name="'.$this->boxinfo['id'].'_noncename" id="'.$this->boxinfo['id'].'_noncename" value="'.wp_create_nonce( 'ashumetabox' ).'" />';     
    }   
       
    //保存字段数据   
    function save_postdata() {   
        if( isset( $_POST['post_type'] ) && in_array($_POST['post_type'],$this->boxinfo['page'] ) && (isset($_POST['save']) || isset($_POST['publish']) ) ){   
        $post_id = $_POST['post_ID'];   
           
        foreach ($this->options as $option) {   
            if (!wp_verify_nonce($_POST[$this->boxinfo['id'].'_noncename'], 'ashumetabox')) {      
                return $post_id ;   
            }   
            //判断权限   
            if ( 'page' == $_POST['post_type'] ) {   
                if ( !current_user_can( 'edit_page', $post_id  ))   
                return $post_id ;   
            } else {   
                if ( !current_user_can( 'edit_post', $post_id  ))   
                return $post_id ;   
            }   
            //将预定义字符转换为html实体   
            if( $option['type'] == 'tinymce' ){   
                    $data =  stripslashes($_POST[$option['id']]);   
            }elseif( $option['type'] == 'checkbox' ){   
                    $data =  $_POST[$option['id']];   
            }else{   
                $data = htmlspecialchars($_POST[$option['id']], ENT_QUOTES,"UTF-8");   
            }   
               
            if(get_post_meta($post_id , $option['id']) == "")   
            add_post_meta($post_id , $option['id'], $data, true);   
               
            elseif($data != get_post_meta($post_id , $option['id'], true))   
            update_post_meta($post_id , $option['id'], $data);   
               
            elseif($data == "")   
            delete_post_meta($post_id , $option['id'], get_post_meta($post_id , $option['id'], true));   
               
        }   
        }   
    }   
    //显示标题   
    function title($values){   
        echo '<p>'.$values['name'].'</p>';   
    }   
    //文本框   
    function text($values){    
        if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];   
           
        echo '<p>'.$values['name'].'</p>';   
        echo '<p><input type="text" style="width:'.$values['size'].'" value="'.$values['std'].'" id="'.$values['id'].'" name="'.$values['id'].'"/>';   
        echo $values['desc'].'</p>';   
    
    }   
         //复选框   
    function checkbox($values){   
        echo '<p>'.$values['name'].'</p>';   
       
            $checked ="";   
            if( is_array($values['std']) && in_array($key,$values['std'])) {   
                $checked = 'checked = "checked"';   
            }   
            echo '<input '.$checked.' type="checkbox" class="kcheck" value="'.$key.'" name="'.$values['id'].'[]"/>'.$value;   
          
        echo '<label for="'.$values['id'].'">'.$values['desc'].'</label><br/></p>';   
    }
  
}   




    
//自定义面板类的实例化      
/**********title*************/     
$options = array();      
     
$boxinfo = array('title' => '独立下载（选择一种模式即可）', 'id'=>'ashubox', 'page'=>array('page','post'), 'context'=>'normal', 'priority'=>'low', 'callback'=>'');      
     
$options[] = array( "name" => "",      
            "type" => "title");      
                  

	
	$options[] = array(
    'id'             => 'down_official',
    'size'             =>'98%',
    'std'              => '',	
    'desc'             => '启用极速下载',
    'type'             => 'checkbox'
    
    );
	$options[] = array(
    'id'             => 'down_reply',
    'size'             =>'98%',
    'std'              => '',	
    'desc'             => '启用评论下载',
    'type'             => 'checkbox'
   
    );
	
	
	$options[] = array(
			'id'             => 'down_demo_url',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '演示地址',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_name',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '资源名称',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_size',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '资源大小',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_date',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '更新时间',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_version',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '适用版本',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_author',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '作者信息',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_url_1',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '百度云盘',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_key_1',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '秘钥 1',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_url_2',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '蓝奏云盘',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_key_2',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '秘钥 2',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_new_name1',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '自定义网盘1',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_url_3',
			'size'             =>'98%', 
            'std'              => '',			
			'name'            => '下载地址1',
			'desc'             => '',
			'type'             => 'text'
	);
		$options[] = array(
			'id'             => 'down_key_3',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '秘钥1',
			'desc'             => '',
			'type'             => 'text'
	);
		$options[] = array(
			'id'             => 'down_new_name2',
			'size'             =>'98%',
            'std'              => '',			
			'name'            => '自定义网盘2',
			'desc'             => '',
			'type'             => 'text'
	);
	$options[] = array(
			'id'             => 'down_url_4',
			'size'             =>'98%', 
            'std'              => '',			
			'name'            => '下载地址2',
			'desc'             => '',
			'type'             => 'text'
	);
		$options[] = array(
			'id'             => 'down_key_4',
			'size'             =>'98%', 
            'std'              => '',			
			'name'            => '秘钥2',
			'desc'             => '',
			'type'             => 'text'
			
	);
		$options[] = array(
			'id'             => 'down_rand1',
			'size'             =>'98%;display: none;', 
            'std'              => rand(1, 999999),			
			'desc'             => '',
			'type'             => 'text'
			
	);
		$options[] = array(
			'id'             => 'down_rand2',
			'size'             =>'98%;display: none;', 
            'std'              => rand(1, 999999),			
			'desc'             => '',
			'type'             => 'text'
			
	);
                  
$new_box = new down_box($options, $boxinfo);      
  
?>