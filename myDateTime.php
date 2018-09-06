<?php
/**
 * date and time
 * create by HoangLe
 * Note: check your timezone
 */
date_default_timezone_set("Asia/Ho_Chi_Minh");
define("END_OF_DAY", mktime(23,29));



class MyDateTime
{
  //return day of month
  function getDate(){
    return (int)date("d");
  }
  //check is end of days
  function isEndOfDay(){
    $time = time();
    if(date("H:m",$time) == date("H:m",END_OF_DAY)){
      return TRUE;
    }
      return FALSE;
  }
  function isEndOfMonth(){
    if($this->getDate() == (int)date("t")){
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
}
?>
