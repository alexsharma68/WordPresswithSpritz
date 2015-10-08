<?php
if(isset($_GET['url'])){
$content=file_get_contents($_GET['url']);
$sel=isset($_GET['selector'])?$_GET['selector']:'';
$selector=array_filter(explode(',',$sel));
if(is_array($selector) && sizeof($selector)>0){
	foreach($selector as $val){
		$splter=array_filter(explode('.',$val));
		$ids=array_filter(explode('|',$val));
		if(substr($val, 0, 1)=='|' || substr($val, 0, 1)=='.'){
			
			$tag=(isset($ids[1]) && $ids[1]!='')?$ids[1]:$splter[1];
			$selector=(isset($ids[1]) && $ids[1]!='')?'id':'class';
			$key=$tag;
			$content=preg_replace('/<div[^>]*'.$selector.'=[\'|"]*[^<]'.$key.'[^>]*[\'|"][^>]*>([^<]+|<(?!\/?div[^>]*>)|<div[^>]*>(?>(?1))*<\/div>)*<\/div>/i', "", $content);
			
			$content=preg_replace('/<article[^>]*'.$selector.'=[\'|"]*[^<]'.$key.'[^>]*[\'|"][^>]*>([^<]+|<(?!\/?article[^>]*>)|<article[^>]*>(?>(?1))*<\/article>)*<\/article>/i', "", $content);
			$content=preg_replace('/<header[^>]*'.$selector.'=[\'|"]*[^<]'.$key.'[^>]*[\'|"][^>]*>([^<]+|<(?!\/?header[^>]*>)|<header[^>]*>(?>(?1))*<\/header>)*<\/header>/i', "", $content);
			$content=preg_replace('/<nav[^>]*'.$selector.'=[\'|"]*[^<]'.$key.'[^>]*[\'|"][^>]*>([^<]+|<(?!\/?nav[^>]*>)|<nav[^>]*>(?>(?1))*<\/nav>)*<\/nav>/i', "", $content);
			$content=preg_replace('/<footer[^>]*'.$selector.'=[\'|"]*[^<]'.$key.'[^>]*[\'|"][^>]*>([^<]+|<(?!\/?footer[^>]*>)|<footer[^>]*>(?>(?1))*<\/footer>)*<\/footer>/i', "", $content);
			$content=preg_replace('/<p[^>]*'.$selector.'=[\'|"]*[^<]'.$key.'[^>]*[\'|"][^>]*>([^<]+|<(?!\/?p[^>]*>)|<p[^>]*>(?>(?1))*<\/p>)*<\/p>/i', "", $content);
			/*$content=preg_replace("/<span[^>]*".$tag."[^>]*>([^<]+|<(?!\/?span[^>]*>)|<span[^>]*>(?>(?1))*<\/span>)*<\/span>/i", "", $content);
			$content=preg_replace("/<table[^>]*".$tag."[^>]*>([^<]+|<(?!\/?table[^>]*>)|<table[^>]*>(?>(?1))*<\/table>)*<\/table>/i", "", $content);
			$content=preg_replace("/<article[^>]*".$tag."[^>]*>([^<]+|<(?!\/?article[^>]*>)|<article[^>]*>(?>(?1))*<\/article>)*<\/article>/i", "", $content);
			$content=preg_replace("/<nav[^>]*".$tag."[^>]*>([^<]+|<(?!\/?nav[^>]*>)|<nav[^>]*>(?>(?1))*<\/nav>)*<\/nav>/i", "", $content);
			$content=preg_replace("/<aside[^>]*".$tag."[^>]*>([^<]+|<(?!\/?aside[^>]*>)|<aside[^>]*>(?>(?1))*<\/aside>)*<\/aside>/i", "", $content);
			$content=preg_replace("/<header[^>]*".$tag."[^>]*>([^<]+|<(?!\/?header[^>]*>)|<header[^>]*>(?>(?1))*<\/header>)*<\/header>/i", "", $content);
			$content=preg_replace("/<footer[^>]*".$tag."[^>]*>([^<]+|<(?!\/?footer[^>]*>)|<footer[^>]*>(?>(?1))*<\/footer>)*<\/footer>/i", "", $content);*/
		}else{
			if(strpos($val,'.')==true){
				$content=preg_replace("/<".$splter[0]."[^>]*".$splter[1]."[^>]*>([^<]+|<(?!\/?".$splter[0]."[^>]*>)|<".$splter[0]."[^>]*>(?>(?1))*<\/".$splter[0].">)*<\/".$splter[0].">/i", "", $content);
			}else if(strpos($val,'|')==true){
				$content=preg_replace("/<".$ids[0]."[^>]*".$ids[1]."[^>]*>([^<]+|<(?!\/?".$ids[0]."[^>]*>)|<".$ids[0]."[^>]*>(?>(?1))*<\/".$ids[0].">)*<\/".$ids[0].">/i", "", $content);
			}else{
				$tag=isset($ids[0])?$ids[0]:$splter[0];
				$content=preg_replace("/<".$tag."\b[^>]*>(?>(?:[^<]++|<(?!\/?".$tag."\b[^>]*>))+|(?R))*<\/".$tag.">/is", "", $content);	
			}
		}
	}
}
echo $content;
}


?>