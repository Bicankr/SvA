<?php
session_start();
require('libs/Smarty.class.php');
require_once 'Lib.php';
require_once('../Config.php');
require_once('../DBConnect.php');
require_once('ArticleLib.php');
require_once('../SvatekLib.php');

$smarty = new Smarty;
//$smarty->debugging = true;
$smarty->$debug_tpl = 'libs/debug.tpl ';
$smarty->caching = false;
$smarty->cache_lifetime = 120;
if ($_SESSION['Logged'] == 'Yes') 
	//$smarty->assign("menu", sprintf('%s%s', '<form action="nLogoutActions.php" method="post"><input type="submit" value="Odhlásit se"/></form>', Menu()));
	$smarty->assign("menu", Menu());
else 
	$smarty->assign("menu", Menu());
include_once "ckeditor/ckeditor.php";

$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->returnOutput = TRUE;


$sql = sprintf('select * from sArticle where ArticleID=%s', $_GET['ArticleID']);
$sth = mysql_query ($sql);
if ($row = mysql_fetch_object ($sth))
{
	if ($_SESSION['Logged'] == 'Yes')
    {
		//$smarty->assign("main", sprintf('<form action="nArticleActions.php" method="post">%s<input type="submit" value="Ulo�it"/><input type="hidden" name="ArticleID" value="%d"></form>', $CKEditor->editor("editor1", $row->Text), $_GET['ArticleID']));
        $smarty->assign("main", sprintf('
            <form method="post" action="nArticleActions.php">
            <textarea id="elm1" name="elm1" rows="15" cols="80">%s</textarea>
            <br />
            <input type="hidden" name="ArticleID" value="%d">    <input type="submit" name="save" value="Ulo�it" />
            <input type="reset" name="reset" value="Reset" />
            </form>', $row->Text, $_GET['ArticleID']));
	}
	else
		$smarty->assign("main", sprintf('%s', $row->Text));
}
else {
	$sql = sprintf('INSERT INTO sArticle(ArticleID) VALUES (%d)', $_GET['ArticleID']);
	$sth = mysql_query ($sql);
}
$smarty->assign("svatek", Svatek());
$smarty->display('eindex.tpl');
?>
