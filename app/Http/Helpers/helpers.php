<?php
if (! function_exists('getfolderName')) {
    function getfolderName(){
    return substr(str_shuffle("01234567890123456789"), 0, 2);
    }
}


if (! function_exists('removeLink')) {
    function removeLink($str){
        $regex = '/<a (.*)<\/a>/isU';
        preg_match_all($regex,$str,$result);
        foreach($result[0] as $rs)
        {
            $regex = '/<a (.*)>(.*)<\/a>/isU';
            $text = preg_replace($regex,'$2',$rs);
            $str = str_replace($rs,$text,$str);
        }
        return $str;
    }
}

if (! function_exists('tagSize')) {
    function tagSize($count){
        $size = 20;
        return   ($count<=10) ? $size + $count : 30;
    }
}






