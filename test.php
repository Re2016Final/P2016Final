<?php

header("Content-type: text/html; charset=utf-8");

function waf($str)
{
    $black_list = array("}", "{", "]", "[", "_", "-", "(", "/", "\\", "*", ")", " ", "#", "'", "%", "a", "b", "c", "e", "f", "g", "h", "j", "k",
                        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    foreach ($black_list as $key => $value)
    {
        if (stripos($str, $value !== false))
        {
            die ("My waf eat your params, it is very delicious");
        }
    }
}

function waf_each($arr)
{
    foreach ($arr as $key => $value)
    {
        waf($key);
        waf($value);
    }
}

waf_each($_GET);
waf_each($_POST);
waf_each($_COOKIE);

function get_flag($var)
{
    $connect = mysql_connect("localhost","***","***");
    if (!$connect)
    {
      die('I am die, help me! Call 110 please.');
    }
    $sqlstr = "select content from ids where id='" . urldecode($var) . "'";
    $result = @mysql_db_query("cnsstest", $sqlstr, $connect);
    $row = @mysql_fetch_row($result);
    if ($row)
    {
        die ($row[0]);
    }
    else
    {
        die("哦，我是一个高冷的waf，懒得给你这个id的内容");
    }
    mysql_close($connect);
}

$uri = explode("?",$_SERVER['REQUEST_URI']);

if(isset($uri[1]))
{
    $parameter = explode("&",$uri[1]);
    foreach ($parameter as $key => $value)
    {
        $var = explode("=", $value);

        if ($var[0] !== 'id')
        {
            die ("PHP eat your params, it is not delicious.<!--Please use another key. if you guess it success, also no egg use:) -->");
        }
        else
        {
            get_flag($var[1]);
        }

    }
}
else
{
  echo "你猜猜我这里有什么";
}

?>
