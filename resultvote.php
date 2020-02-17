
<?
include("config.php");
include("lib.php");
$link = opendb();

 echo" <style type=\"text/css\">
body {
  color: black;
  font: 11px verdana;
  background-color:#F8FDF1;</style>";

$query = doquery ( "SELECT * FROM {{table}} WHERE numero='$id' AND ip='$REMOTE_ADDR'","sondage_ip");

$lignes = mysql_num_rows($query); 
if($lignes == 0)
{
$query = doquery ("INSERT INTO {{table}} VALUES('$id','$REMOTE_ADDR')","sondage_ip");

$query = doquery ( "INSERT INTO {{table}} VALUES('$id', '$reponse')","resultats");

echo 'Merci d\'avoir voté !';

}
else
{
echo '<span class="alerte">Vous avez déjà voté !</span>';

}

$query = doquery ("SELECT * FROM {{table}}  ORDER BY id DESC LIMIT 0,1", "sondage");
$resultat = mysql_fetch_array($query);
{
$id_sondage = $resultat[id];

$re_1 = $resultat[reponse1];
$re_2 = $resultat[reponse2];
$re_3 = $resultat[reponse3];
$re_4 = $resultat[reponse4];


$query2 = doquery ("SELECT * FROM {{table}} WHERE numero='$id_sondage'", "resultats");
$votes = mysql_num_rows($query2);
if($votes == 0)
{
$votes = 1;
}
$query3 = doquery ("SELECT * FROM {{table}} WHERE numero='$id_sondage' AND reponse='1'", "resultats");
$rep1 = mysql_num_rows($query3);
$query4 = doquery ("SELECT * FROM {{table}} WHERE numero='$id_sondage' AND reponse='2'", "resultats");
$rep2 = mysql_num_rows($query4);
$query5 = doquery ("SELECT * FROM {{table}} WHERE numero='$id_sondage' AND reponse='3'", "resultats");
$rep3 = mysql_num_rows($query5);
$query6 = doquery ("SELECT * FROM {{table}} WHERE numero='$id_sondage' AND reponse='4'", "resultats");
$rep4 = mysql_num_rows($query6);


	$deb1 = 100*$rep1;
	$fin1 = $deb1 / $votes;
	$deb2 = 100*$rep2;
	$fin2 = $deb2 / $votes;
	$deb3 = 100*$rep3;
	$fin3 = $deb3 / $votes;
	$deb4 = 100*$rep4;
	$fin4 = $deb4 / $votes;

echo '<script language="javascript">
reponse1 = Math.round('.$fin1.');
reponse2 = Math.round('.$fin2.');
reponse3 = Math.round('.$fin3.');
reponse4 = Math.round('.$fin4.');

nombre1 = ('.$rep1.');
nombre2 = ('.$rep2.');
nombre3 = ('.$rep3.');
nombre4 = ('.$rep4.');
';
$query7 = doquery ("SELECT * FROM {{table}} WHERE numero='$id_sondage' AND ip='$REMOTE_ADDR'", "sondage_ip");
$lignes = mysql_num_rows($query7);
if($lignes == 1)
{

if(!empty($re_1))
{
echo '
document.write(\'<br><br><b>'.$re_1.'</b> <img border="0" src="images/sondage/barresondage.gif" height=7 WIDTH="\'+reponse1+\'"><b> \'+reponse1+\'%</b> (\'+nombre1+\')<br>\');
';
}
if(!empty($re_2))
{
echo '
document.write(\'<b>'.$re_2.'</b> <img border="0" src="images/sondage/barresondage.gif" height=7 WIDTH="\'+reponse2+\'"> <b> \'+reponse2+\'%</b> (\'+nombre2+\')<br>\');
';
}
if(!empty($re_3))
{
echo '
document.write(\'<b>'.$re_3.'</b> <img border="0" src="images/sondage/barresondage.gif" height=7 WIDTH="\'+reponse3+\'"> <b> \'+reponse3+\'%</b> (\'+nombre3+\')<br>\');
';
}
if(!empty($re_4))
{
echo '
document.write(\'<b>'.$re_4.'</b> <img border="0" src="images/sondage/barresondage.gif" height=7 WIDTH="\'+reponse4+\'"> <b> \'+reponse4+\'%</b> (\'+nombre4+\')<br>\');
';
}
echo '</script>';
echo '<br> <img border="0" src="images/sondage/persosondage.jpg">';
}
}
?>

