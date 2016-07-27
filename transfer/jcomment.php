<?php
$pass = 'pass';
$firstdb = new mysqli('localhost','root',$pass,'maryam');
$seconddb = new mysqli('localhost','root',$pass,'joomla');
if ($firstdb->connect_errno){
    exit('failed to connect, the error id:'.'<br/>'.$firstdb->connect_errno.':'.$firstdb->connect_error);
}
if ($seconddb->connect_errno){
    exit('failed to connect, the error id:'.'<br/>'.$seconddb->connect_errno.':'.$seconddb->connect_error);
}
$firstdb -> set_charset('utf8');
$seconddb -> set_charset('utf8');
$result = $firstdb ->query('SELECT * FROM `comments`');
    while ( $data = $result->fetch_object()){
        $news_id = $data->news_id;
		$object_group = 'com_content';
		$lang ='en-GB';
		$name = $data->name;
		$email = $data->email;
		$comment = $data->body;
		$newdate = new DateTime($data->i_date.$data->i_time);
        $joomladate = $newdate->format("Y-m-d H:i:s");   
		$query = "INSERT INTO `joomla_jcomments`(`id`, `parent`, `thread_id`, `path`, `level`, `object_id`, `object_group`, `object_params`, `lang`, `userid`, `name`, `username`, `email`, `homepage`, `title`, `comment`, `ip`, `date`, `isgood`, `ispoor`, `published`, `deleted`, `subscribe`, `source`, `source_id`, `checked_out`, `checked_out_time`,`editor`) VALUES (NULL,0,0,0,0,'{$news_id}','{$object_group}','','{$lang}',0,'{$name}','{$name}','{$email}','','','{$comment}','','{$joomladate}',0,0,1,0,0,'',0,0,'{$joomladate}','')";
        $res = $seconddb ->query($query);
        if ( $res == TRUE){
        echo "New record created successfully".'<br>'; 		
         } 
		else{
		echo $seconddb->connect_errno.':'.$seconddb->connect_error.'<br>';	
		}
    }
