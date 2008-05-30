<?php

class query {

  private $ErrMsg = "Error: ";
  private $db;
  private $result;

  function __construct() {
  } // end definition function __construct()

  function __destruct() {
//    $this->db->close();
  }

  public function Run() {
    if ( isset($_GET['act']) ) {
      switch ($_GET['act']){
        case 'get':
          if ( isset($_GET["uID"])) {
            if ( $_GET["uID"] == "all") {
              $this->getAll();
            } else {
              $this->Error(5, "Not implemented yet. Return ");
            }
          } else {
            $this->Error(-4, $this->ErrMsg);
          }
          break;
        case 'add':
//echo $_GET['uName'], $_GET['uMail'], $_GET['uBirth'], $_GET['uSex'];
          if ( isset($_GET['uName']) && isset($_GET['uMail']) &&
               isset($_GET['uBirth']) && isset($_GET['uSex']) ){ // добавить проверки мыла, др и т.д
            $this->addUser( $_GET['uName'], $_GET['uMail'],
                            $_GET['uBirth'], $_GET['uSex'] );
//            $this->Error(2, "Not implemented yet. Return ");
          } else {
            $this->Error(-3, $this->ErrMsg);
          }
          break;
        case 'edit': // добавить проверу uID
          $this->Error(3, "Not implemented yet. Return ");
          break;
        default:
          $this->Error(-2, $this->ErrMsg);
      }
    } else { // нет такого action! (-1)
      $this->Error(-1, $this->ErrMsg);
    }
  }

  private function getAll() {
    mb_internal_encoding("UTF-8");
    $this->db = new mysqli("10.12.19.2", "birth_mail", "", "birth_mail");

    if (mysqli_connect_errno()) { 
      printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error()); 
      exit; 
    }
//    mysql_query('SET character_set_results="utf8"'); 
//    mysql_query("SET CHARACTER SET utf8"); 
//    mysql_query("SET NAMES 'utf8'");

    $this->result = $this->db->query("set names UTF8");
    if ( $this->result = $this->db->query("select * from people") ) {
      $dom = new DOMDocument("1.0");
      header("Content-Type: text/xml");
      $users = $dom->createElement("users");
      $dom->appendChild($users);
      $i = 0;
      while ( $row = $this->result->fetch_assoc() ){
        $user = $dom->createElement('user');
        $users->appendChild($user);
        $i++;
        foreach($row as $key=>$value){
          $element = $dom->createElement($key);
          $user->appendChild($element);
          $elementText = $dom->createTextNode($value);
          $element->appendChild($elementText);
        }
      }
      echo $dom->saveXML();
      $this->result->close();
    }
    return;
  }

  private function addUser($uName, $uMail, $uBirth, $uSex) {
//$sql = "INSERT INTO `birth_mail`.`people` (`uID`, `name`, `mail`, `birth`, `sex`)
//VALUES (NULL, 'test', 'test@test.net', '2008-05-12', 'm');";

    mb_internal_encoding("UTF-8");
    $db = new mysqli("10.12.19.2", "birth_mail", "", "birth_mail");

    if (mysqli_connect_errno()) { 
      printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error()); 
      exit; 
    }
//    mysql_query('SET character_set_results="utf8"'); 
//    mysql_query("SET CHARACTER SET utf8"); 
//    mysql_query("SET NAMES 'utf8'");

    $result = $db->query("set names UTF8");
    if ( $result = $db->query("INSERT INTO `birth_mail`.`people` (`uID`, `name`, `mail`, `birth`, `sex`)
                               VALUES (NULL, '$uName', '$uMail', '$uBirth', '$uSex');") ) {
      $this->Error( -321, "addUser. user added!  ");//+$result);
    } else {
      $this->Error( $db->error, "addUser. user NOT added! Reason:  ");//+$result);
    }
return;
/*      $dom = new DOMDocument("1.0");
      header("Content-Type: text/xml");
      $users = $dom->createElement("users");
      $dom->appendChild($users);
      $i = 0;
      while ( $row = $result->fetch_assoc() ){
        $user = $dom->createElement('user');
        $users->appendChild($user);
        $i++;
        foreach($row as $key=>$value){
          $element = $dom->createElement($key);
          $user->appendChild($element);
          $elementText = $dom->createTextNode($value);
          $element->appendChild($elementText);
        }
      }
      echo $dom->saveXML();
      $result->close();
    }
    return; */
  }

  private function Error($code, $message = "") {
    header("Content-Type: text/xml");
    $dom = new DOMDocument("1.0");
    $users = $dom->createElement("users");
    $users->setAttribute("status", $code);
    $dom->appendChild($users);
    if ( !empty($message) ) {
      $element = $dom->createElement("message");
      $users->appendChild($element);
      $elementText = $dom->createTextNode($message.$code);
      $element->appendChild($elementText);
    }
    echo $dom->saveXML();
    return;   
  }
} //end definition class query

$zxc = new query();
$zxc->Run();

exit;
?>
