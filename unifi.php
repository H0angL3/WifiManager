<?php
/**
 * 5/9/2018
 * Caculate usage data of user at at the moment UnifiController
 * Create by HoangLe
 */

 require_once('vendor/autoload.php');
 require_once('config.php');
 require_once('myDateTime.php');



 class UnifiController{
  private  $site_id = 'default';
  private $unifi_connection = '';
  private $avalDataDown = 2147483648; //default 2gb
  private $avalDataUp = 1073741824; //default 1gb
  var $dateTime;
  //$dateTime = new myDateTime;
  //TODO Login to unifi controller
  /**
   * initialize the Unifi API connection class, log in to the controller and request the alarms collection
   * (this example assumes you have already assigned the correct values to the variables used)
   *ssl false
   */
  function __construct($controller_user, $controller_password, $controller_url, $site_id){
    $this->unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id);
    $login = $this->unifi_connection->login();
    $results = $this->unifi_connection->list_alarms(); // returns a PHP array containing alarm objects
  }
  //TODO get mac and tx_bytes, rx_bytes of online users
  /*
  * this get tx, rx, mac of user and return an array
  *output like: [mac] =>([tx], [rx])
  */
  public function getOnlineUsers(){
      $data = $this->unifi_connection->list_clients();
      $dataOnlineUser = array();

      foreach ($data as $userdata) {
        if(!isset($userdata->tx_bytes)){
            $userdata->tx_bytes = 0;
        }
        if(!isset($userdata->rx_bytes)){
          $userdata->rx_bytes = 0;
        }
        $dataOnlineUser[$userdata->mac] = array("down"=>$userdata->tx_bytes,"up"=> $userdata->rx_bytes);

      }
      return $dataOnlineUser;
  }

  //TODO get information all users in statics
  /*
  * return mac, hostname, oui, txbytes, rxbytes in insight
  * ouput like [mac] => ([host], [oui], [blocked], [tx], [rx])
  */
  public function statAllUsers(){
      $data = $this->unifi_connection->stat_allusers();
      $dataAllUser = array();
      foreach ($data as $userdata) {
        if(!isset($userdata->hostname)){
            $userdata->hostname = "unkown";
        }
        if(!isset($userdata->oui)){
            $userdata->oui = "unkown";
        }
        if(!isset($userdata->tx_bytes)){
            $userdata->tx_bytes = 0;
        }
        if(!isset($userdata->rx_bytes)){
          $userdata->rx_bytes = 0;
        }
        //doan nay co van de/........s
        if(isset($userdata->blocked) && $userdata->blocked == 1){

        }
        else{
          $userdata->blocked = 0;
        }
        $dataAllUser[$userdata->mac] = array("hostname" => $userdata->hostname,"oui" => $userdata->oui,"blocked" => $userdata->blocked ,"down" => $userdata->tx_bytes, "up" => $userdata->rx_bytes);

      }
      return $dataAllUser;
  }

  /*TODO get infomation of all all_users
  *return mac, hostname, oui, txbytes, rxbytes at now
  * tx = tx[user] + tx[insight],.....
  * ouput like [mac] => ([host], [oui], [tx], [rx])
  *
  */
  public function getAllUsers(){
      //get online user and statics user
      $onlineUser = $this->getOnlineUsers();
      $allUser = $this->statAllUsers();
      $_macOnline = array_keys($onlineUser);
      //add tx and rx bytes firm online to statics same mac
      foreach ($_macOnline as $macOnline) {
        if(array_key_exists($macOnline, $allUser)){
          //add down and up to $allUser
          $allUser[$macOnline]["down"] += $onlineUser[$macOnline]["down"];
          $allUser[$macOnline]["up"] += $onlineUser[$macOnline]["up"];
        }
      }
      return $allUser;
  }
  /*
  *TODO block user by mac
  */
  public function blockUser($mac){
    $this->unifi_connection->block_sta($mac);
  }
  /*
  *TODO unblock user by mac
  */
  public function unblockUser($mac){
    $this->unifi_connection->unblock_sta($mac);
    sleep(1);
  }
  /*
  * TODO  data usage limit user..
  * user dung qua luu luong hang ngay -> block
  * user dung it hon luu luong MAX -> cong luu luong thua vao ngay hom sau.
  * maximum:    usageData/Month = $MAX_DATA_USAGE_PER_DAY * [number of days in a month] (28, 29, 30days or 31days)
  * xoa luu luong vao moi thang
  */
  public function setMaxDataUsage($MAX_DATA_DOWN_PER_DAY, $MAX_DATA_UP_PER_DAY){
    $this->dateTime = new MyDateTime;
    $this->avalDataDown = (float)(($MAX_DATA_DOWN_PER_DAY * 1024 * 1024 * 1024) * $this->dateTime->getDate());    //convert to bytes
    $this->avalDataUp = (float)(($MAX_DATA_UP_PER_DAY * 1024 * 1024 * 1024) * $this->dateTime->getDate());    //convert to bytes
  }
  public function getMaxDataUsage(){
    return array("down" => $this->avalDataDown, "up" =>$this->avalDataUp);
  }
  public function limitDataUsage(){
    //available data TODAY.
    //$MAX_DATA_USAGE_PER_DAY (GB)

    //var_dump($avalDataDown);
    //check upload and download usage and block user
    $user = $this->getAllUsers();
    $_macUser = array_keys($user);
    // foreach ($_macUser as $mac) {
    //     if($user[$mac]["down"] >= $avalDataDown || $user[$mac]["up"] >= $avalDataUp){
    //       $this->blockUser($mac);
    //     }
    // }
    /*
    * UNBLOCK USER AT END OF DAY
    */
  }

  /*
  * UNBLOCK USER AT END OF DAY
  */
}
// $unifiController = new UnifiController($controller_user, $controller_password, $controller_url, $site_id);
// echo "<br>";
// $unifiController->setMaxDataUsage(2,1);
// var_dump($unifiController->getMaxDataUsage());
// //$unifiController->blockUser("2c:29:97:08:43:c0");
?>
