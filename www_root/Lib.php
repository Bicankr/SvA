<?php
function Menu()
{
	return '
	<a href="index.php?MenuId=1">Úvodní strana</a>
	<a href="nArticle.php?ArticleID=1000">Informace o domovu</a>
	<a href="nArticle.php?ArticleID=1001">Poslání a cíle sociální služby</a>
    <a href="KeStazeni.php">Dokumenty ke stažení</a>
    <a href="nFotografie.php">Fotografie</a>
	<a href="nArticle.php?ArticleID=1002">Kontakty</a>
	<a href="nArticle.php?ArticleID=1003">Nabídka zamìstnání</a>
	<a href="nMapa.php">Kde nás najdete</a>
	';
//    <a href="nDeni.php">Dï¿½nï¿½ v domovï¿½</a>
//    <a href="nFotografie.php?MenuId=1004">Fotografie</a>
}

function nArticle($ArticleID)
{
	$sql = sprintf('select * from sArticle where ArticleID=%s', $ArticleID);
	$sth = mysql_query ($sql);
	$ret = sprintf('<br />');
	while ($row = mysql_fetch_object ($sth)) 
	{
		$ret = sprintf('%s<a href="Article.php?ArticleID=%s">%s</a><p>%s</p>', $ret, $row->ArticleID , $row->Title, $row->Text);
	}
	$sql = sprintf('select FotoID, Soubor, Text from sFoto where ArticleID=%d', $_GET['ArticleID']);
	$sth = mysql_query ($sql);
	while ($row = mysql_fetch_object ($sth)) 
	{
		$ret = sprintf('%s<img src="./Obrazky/%s"><p>%s</p>', $ret, $row->Soubor, $row->Text);
	}
	return $ret;
}

function Hiddens($v) 
{
    $ret = '';    
    if (isset($_GET[$v])) $ret = sprintf('<input type="hidden" name="%s" value="%d" />', $v, $_GET['$v']);
    if (isset($_POST[$v])) $ret .= sprintf('<input type="hidden" name="%s" value="%d" />', $v, $_POST['$v']);
    return $ret;
}
    
function Loguj($msg)
{
    //die ($_SERVER["SCRIPT_NAME"]);

    $myFile = "logs/log.txt";
    if($msg=='reset'){
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, 'reset');
    }else{
        $fh = fopen($myFile, 'a') or die("can't open file - ".$myFile);
        fwrite($fh, $msg."\r\n");
        fclose($fh);
    }
}

?>