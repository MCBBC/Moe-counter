<?php
if (!defined('access') or !access) {
    die('This file cannot be directly accessed.');
}
function getData($name, $type)
{
    $Db = new dbManager;
    $name_md5 = md5($name);
    switch ($type) 
    {
        case 'select':
            $select_name_sql = "SELECT * FROM `counter` WHERE `name` = '$name_md5'";
            $data = $Db->query($select_name_sql);
            break;
            
        case 'insert':
            $insert_name_sql = "INSERT INTO `counter` (`name`, `counter`, `def_name`) VALUES ('$name_md5', '1', '$name')";
            $data = $Db->exec($insert_name_sql);
            break;
            
        case 'update':
            $update_name_sql = "UPDATE `counter` SET `counter` = counter + 1 WHERE `name` = '$name_md5'";
            $data = $Db->exec($update_name_sql);
            break;

        default:
            $select_name_sql = "SELECT * FROM `counter` WHERE `name` = '$name_md5'";
            $data = $Db->query($select_name_sql);
            break;
    }
    return $data;
}

function fileToBase64($file)
{
    $base64_file = '';
    if(file_exists($file))
    {
        $mime_type= mime_content_type($file);
        $base64_data = base64_encode(file_get_contents($file));
        $base64_file = 'data:'.$mime_type.';base64,'.$base64_data;
    }
    return $base64_file;
}
