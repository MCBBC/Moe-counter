<?php
    define('access', 'index');
    define('config', include_once("Class/Config.class.php"));
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'zh_CN';
    function getDirContent($path){
        if(!is_dir($path)){
            return "error";
        }
        $arr = array();
        $data = scandir($path);
        foreach ($data as $value){
            if($value != '.' && $value != '..'){
                $arr[] = $value;
            }
        }
        return $arr;
    }
    $data = getDirContent("Lang/");
    include("Class/Lang.class.php");
?>
<html>
    <head>
        <title><?php echo $_LANG['title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/png" href="favicon.png" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/light.min.css" />
        <style>
            a {
                color: #000000;
            }
            a:hover {
                color: #03a9f4;
                text-decoration: none;
            }
            .a-select {
                color: #03a9f4;
            }
            .text-decoration {
                padding-bottom: 5px;
                border-bottom: 1px solid #000;
            }
            .text-decoration:hover {
                color: #03a9f4;
                border-bottom: 1px solid #03a9f4;
            }
        </style>
    </head>
    <body>
        <h3><?php echo $_LANG['info.1']; ?></h3>
        <p><?php echo $_LANG['info.2']; ?></p>
        <p style="text-decoration: line-through"><?php echo $_LANG['info.3']; ?></p>
        <p><?php echo $_LANG['info.4']; ?></p>
        <p><?php echo $_LANG['info.12']; ?> <a href="https://github.com/MCBBC/Moe-counter" target="_blank"><code class="text-decoration">Github@MCBBC/Moe-counter</code></a></p>
        <h3><?php echo $_LANG['info.5']; ?></h3>
        <h5><?php echo $_LANG['info.6']; ?></h5><code><?php echo config['web']['url'] ?>/get/@:name</code>
        <h5><?php echo $_LANG['info.7']; ?></h5><code>&lt;img src="<?php echo config['web']['url'] ?>/get/@:name" alt=":name" /></code>
        <h5><?php echo $_LANG['info.8']; ?></h5><code>![:name](<?php echo config['web']['url'] ?>/get/@:name)</code>
        <h3>eg:<img src="<?php echo config['web']['url'] ?>/get/@index" alt="Moe Count!" /></h3>
        <i><?php echo $_LANG['info.9']; ?></i>
        <details>
            <summary style="display: inline-block;">
                <h3 style="display: inline-block; cursor: pointer;" class="text-decoration"><?php echo $_LANG['info.10']; ?></h3>
            </summary>
            <p style="margin: 0;"><?php echo $_LANG['info.11']; ?></p>
            <h5><a href="https://www.asoulworld.com/" target="_blank">asoul</a></h5>
            <img src="<?php echo config['web']['url'] ?>/get/@demo?theme=asoul" alt="A-SOUL" />
            <h5><a href="https://rule34.xxx/" target="_blank">rule34 <span style="color: red;">[NSFW]</span></a></h5>
            <img src="<?php echo config['web']['url'] ?>/get/@demo?theme=rule34" alt="Rule34" />
            <h5><a href="https://github.com/moebooru/moebooru" target="_blank">moebooru</a></h5>
            <img src="<?php echo config['web']['url'] ?>/get/@demo?theme=moebooru" alt="Moebooru" />
            <h5><a href="https://github.com/moebooru/moebooru" target="_blank">moebooru-h</a></h5>
            <img src="<?php echo config['web']['url'] ?>/get/@demo?theme=moebooru-h" alt="Moebooru-Hentai" />
            <h5><a href="https://gelbooru.com/" target="_blank">gelbooru <span style="color: red;">[NSFW]</span></a></h5>
            <img src="<?php echo config['web']['url'] ?>/get/@demo?theme=gelbooru" alt="Gelbooru" />
            <h5><a href="https://gelbooru.com/" target="_blank">gelbooru-h <span style="color: red;">[NSFW]</span></a></h5>
            <img src="<?php echo config['web']['url'] ?>/get/@demo?theme=gelbooru-h" alt="Gelbooru-Hentai" />
        </details>
        <details>
            <summary style="display: inline-block;">
                <h3 style="display: inline-block; cursor: pointer;" class="text-decoration"><?php echo $_LANG['html.lang']; ?></h3>
            </summary>
            <?php
                foreach($data as $key => $value) {
                    $json_string = json_decode(file_get_contents('Lang/'.$value), true);
                    if($lang === $json_string['region']){
                        $Html_Class = "a-select";
                    } else {
                        $Html_Class = "a-noselect";
                    }
                    echo $key = '<p><a href="?lang='.pathinfo($value, PATHINFO_FILENAME).'" class="'.$Html_Class.'">'.$json_string['language'].'</a></p>';
                }
            ?>
        </details>
    </body>
</html>
