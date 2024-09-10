<?php

class SiteHelpers
{

	public static function alert( $task , $message)
	{
		if($task =='error') {
			$alert ='<div class="alert alert-danger msg"><i class="fa fa-exclamation-circle"></i> '. $message.' </div>';			
		} elseif ($task =='success') {
			$alert ='<div class="alert alert-success msg"><i class="fa fa-check-circle"></i> '. $message.' </div>';		
		} elseif ($task =='warning') {
			$alert ='<div class="alert alert-warning msg"><i class="fa fa-exclamation-triangle"></i> '. $message.' </div>';
		} else {
			$alert ='<div class="alert alert-info msg"><i class="fa fa-info"></i> '. $message.' </div>';
		}
		return $alert;
		
	} 	
	

	public static function check_session_status()
	{
		
	}

	public static function avatar_class($class = "img-fluid")
	{
		$_this = & get_Instance();
		$avatar = '<img alt="" src="'.site_url().'/assets/assets/img/logo.png" class="'.$class.'" />';
		$files =  './uploads/users/'.$_this->session->userdata('avatar') ;
		if($_this->session->userdata('avatar') !='' ) 	
		{
			if( file_exists($files))
			{
				return  '<img src="'.site_url().'uploads/users/'.$_this->session->userdata('avatar').'" border="0" class="'.$class.'"  />';
			} else {
				return $avatar;
			}	
		} else {
			return $avatar;
		}
	}	

	public static function avatar_class_members($class = "img-fluid",$filename = null)
	{
		$_this = & get_Instance();
		$avatar = '<img alt="" src="'.site_url().'/assets/assets/img/logo.png" class="'.$class.'" />';
		$files =  './uploads/users/'.$filename ;
		if($filename!='' ) 	
		{
			if( file_exists($files))
			{
				return  '<img src="'.site_url().'uploads/users/'.$filename.'" border="0" class="'.$class.'"  />';
			} else {
				return $avatar;
			}	
		} else {
			return $avatar;
		}
	}

	public static function avatar_width( $width =75, $class = "img-fluid")
	{
		$_this = & get_Instance();
		$avatar = '<img alt="" src="'.site_url().'/assets/assets/img/logo.png" class="'.$class.'" width="'.$width.'" />';
		$files =  './uploads/users/'.$_this->session->userdata('avatar') ;
		if($_this->session->userdata('avatar') !='' ) 	
		{
			if( file_exists($files))
			{
				return  '<img src="'.site_url().'uploads/users/'.$_this->session->userdata('avatar').'" border="0" width="'.$width.'" class="'.$class.'" />';
			} else {
				return $avatar;
			}	
		} else {
			return $avatar;
		}
	}	
	
}
