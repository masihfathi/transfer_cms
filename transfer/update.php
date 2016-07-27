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
$result = $firstdb ->query('SELECT * FROM `stats`');
    while ( $data = $result->fetch_object()){
		$id = $data->matlab_id;
		$rating_sum = $data->JameSetareh;
		$rating_count = $data->TedadBarEmteyaz;

        $query = "INSERT INTO `joomla_content_rating`(`content_id`, `rating_sum`, `rating_count`, `lastip`) VALUES ('{$id}','{$rating_sum}','{$rating_count}','')";
        $res = $seconddb ->query($query);
        if ( $res == TRUE){
        echo "New Insert successfully".'<br>';
         } 
    }
