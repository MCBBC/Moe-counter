<?php
header('Content-Type:image/svg+xml'); 
define('access', 'get');
include_once("Class/Mysql.class.php");
include_once("Class/Tools.class.php");

$name = $_GET['name'] ? $_GET['name'] : 'demo';
$theme = $_GET['theme'] ? $_GET['theme'] : 'rule34';
$x = 0;

switch ($theme) 
{
    case 'gelbooru':
        $width = '68';
        $height = '150';
    break;
        
    case 'gelbooru-h':
        $width = '68';
        $height = '150';
    break;
    
    default:
        $width = '45';
        $height = '100';
    break;
}

switch ($name) 
{
    case 'demo':
        $mun = '1234567890';
        $PLACES = 10;
    break;
    
    default:
        if(getData($name, 'select'))
        {
            getData($name, 'update');
            $data = getData($name, 'select');
            $mun = $data['counter'];
        }
        else
        {
            getData($name, 'insert');
            $mun = '1';
        }
        $PLACES = 7;
    break;
}

        
$referer = $_SERVER["HTTP_REFERER"];
if(!empty($referer))
{
    getData($name, 'referer', urlencode($referer));
}
$str = sprintf("%07d", $mun); //里面的07是一共显示几个数
$chars = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
$allWidth = $width * $PLACES;
$outSvg = '<?xml version="1.0" encoding="UTF-8"?><svg width="'.$allWidth.'" height="'.$height.'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Moe Count</title><g>';
foreach ($chars as $val)
{
    $files = fileToBase64("Theme/".$theme."/$val.gif");
    $outSvg .=  '<image x="'.$x.'" y="0" width="'.$width.'" height="'.$height.'" xlink:href="'.$files.'" />'."\n";
    $x += $width;
}
$outSvg .= '</g></svg>';
echo $outSvg;
