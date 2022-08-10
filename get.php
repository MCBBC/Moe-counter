<?php 
define('access', 'get');
header('Content-Type:image/svg+xml; charset=utf-8'); 
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Content-Encoding:gzip');
include_once("Class/Sqlite.class.php");
include_once("Class/Tools.class.php");

$name = addslashes(strip_tags(trim($_GET['name'] ? $_GET['name'] : 'demo'))); // 名称
$theme = addslashes(strip_tags(trim($_GET['theme'] ? $_GET['theme'] : 'rule34'))); // 主题
$show = addslashes(strip_tags(trim($_GET['show'] ? $_GET['show'] : '10'))); // 显示数字位数，默认10位
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
        $long = 10;
    break;
    
    default:
        if(getData($name, 'select'))
        {
            getData($name, 'update');
            $data = getData($name, 'select');
            $mun = $data['2'];
        }
        else
        {
            getData($name, 'insert');
            $mun = '1';
        }
    break;
}

if($show < strlen($mun))
{
    $long = strlen($mun) + 2;
} 
elseif($show > 20) 
{
    $long = strlen($mun) + 2;
} 
else
{
    $long = $show;
}

$str = sprintf("%0".$long."d", $mun); //里面的07是一共显示几个数
$chars = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
$allWidth = $width * $long;
$outSvg = '<?xml version="1.0" encoding="UTF-8"?><svg width="'.$allWidth.'" height="'.$height.'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Moe Count</title><g>';
foreach ($chars as $val)
{
    $files = fileToBase64("Theme/".$theme."/$val.gif");
    $outSvg .=  '<image x="'.$x.'" y="0" width="'.$width.'" height="'.$height.'" xlink:href="'.$files.'" />'."\n";
    $x += $width;
}
$outSvg .= '</g></svg>';
$outSvg = gzencode($outSvg, 9);
echo $outSvg;
