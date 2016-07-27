<?php
//auther masih fathi , masihfathi@gmail.com
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
$result = $firstdb ->query('SELECT * FROM `mataleb`');
$asset_id = 1321;
$lft = 25;
$rgt = 26;
    while ( $data = $result->fetch_object()){
        $language = '*';        
        $newdate = new DateTime($data->date.$data->time);
        $joomladate = $newdate->format("Y-m-d H:i:s");        
        $metadata = '{"robots":"","author":"","rights":"","xreference":""}';
        $attribs = '{"show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}';
        $urls = '{"urla":false,"urlatext":"","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}';
        $images = '{"image_intro":"images\/old\/'.$data->imageSmall.'","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"images\/old\/'.$data->imageBig.'","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}';
        $catid = $data->cat_id;
        $fulltext = $data->matn;
        $introtext = $data->kholase;
		$alias = str_replace(" ","-",$data->titr);
        $title = $data->titr;
		$id = $data->id;
        $query = "INSERT INTO `joomla_content`(`id`, `asset_id`, `title`, `alias`, `introtext`, `fulltext`, `state`, `catid`, `created_by`, `images`, `urls`, `attribs`, `access`, `hits`, `metadata`, `featured`, `language`,`created`,`modified`,`checked_out_time`,`publish_up`,`publish_down`,`metakey`,`metadesc`,`xreference`) VALUES ($id,$asset_id,'{$title}','{$alias}','{$introtext}','{$fulltext}',1,$catid, 482 ,'{$images}','{$urls}','{$attribs}',1,0,'{$metadata}',0,'{$language}','{$joomladate}','{$joomladate}','{$joomladate}','{$joomladate}', '2516-07-21 13:35:38' ,'','','')";
        $res = $seconddb ->query($query);
        $name = 'com_content.article.'.$id;
        $rules = '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}';
        if ( $res == TRUE){
        echo "New record created successfully".'<br>';
        $secondquery = "INSERT INTO `joomla_assets`(`id`, `parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES (NULL,27,$lft,$rgt,3,'{$name}','{$title}','{$rules}')";
        $seconddb ->query($secondquery);        
        $asset_id = $asset_id + 1;                      
        $lft = $lft + 2;                      
        $rgt = $rgt + 2;  
         } 
    }
