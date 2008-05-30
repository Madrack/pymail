<?php
// create doctype
$dom = new DOMDocument("1.0");

//$dom->create_attribute("codepage", "cp1251");

// display document in browser as plain text 
// for readability purposes
header("Content-Type: text/xml");

// create root element
$users = $dom->createElement("users");
$dom->appendChild($users);

// create child element
$user = $dom->createElement("user");
$users->appendChild($user);
$user->setAttribute("uId", "12345");

$uName = $dom->createElement("name");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("Иванов Иван Иванович");
$uName->appendChild($uNameText);

$uName = $dom->createElement("mail");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("ivanov@pisem.net");
$uName->appendChild($uNameText);

$uName = $dom->createElement("birth");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("12.12.1970");
$uName->appendChild($uNameText);

//Добавление пользователя
$user = $dom->createElement("user");
$users->appendChild($user);
$user->setAttribute("uId", "123456");

$uName = $dom->createElement("name");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("Петров Петр Петрович");
$uName->appendChild($uNameText);

$uName = $dom->createElement("mail");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("petrov@pisem.net");
$uName->appendChild($uNameText);

$uName = $dom->createElement("birth");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("11.11.1960");
$uName->appendChild($uNameText);

// create another text node
$text = $dom->createTextNode("Иванов");
$user->appendChild($text);

//Добавление пользователя
$user = $dom->createElement("user");
$users->appendChild($user);
$user->setAttribute("uId", "1234");

$uName = $dom->createElement("name");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("Сидоров Сидор Сидорович");
$uName->appendChild($uNameText);

$uName = $dom->createElement("mail");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("sidorov@pisem.net");
$uName->appendChild($uNameText);

$uName = $dom->createElement("birth");
$user->appendChild($uName);
$uNameText = $dom->createTextNode("10.10.1980");
$uName->appendChild($uNameText);

$dom->save('file.xml');
// save and display tree
echo $dom->saveXML();
//$doc = new DOMDocument("1.0");
//$node = $doc->createElement("para");
//$newnode = $doc->appendChild($node);
//$newnode->setAttribute("align", "left");
//echo $doc->saveXML();
?>
