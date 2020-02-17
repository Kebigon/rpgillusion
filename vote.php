<html>
<head>
<title>Sondage</title>
</head>

<body>
<?

print '
<script language="javascript">



function sonde()
{
newWindow=open("","Sondage","width=200,height=200,scrolling=no,resizable=no,scrollbars=yes");
newWindow.focus();

}
</script>';
include("config.php");

$link = opendb();

$query = doquery ("SELECT * FROM {{table}}  ORDER BY id DESC LIMIT 0,1", "sondage");
$resultat = mysql_fetch_array($query);
{
$id_sondage = $resultat[id];
print '<br><br><img src="images/main_nav2.jpg"> <table>
<form method="POST" action="resultvote.php?id='.$id_sondage.'" target="Sondage" onsubmit="sonde()" >
<b><font color="#67aa2b">'.$resultat[question].'</font></b></table>

';
echo "";
$re_1 = $resultat[reponse1];
$re_2 = $resultat[reponse2];
$re_3 = $resultat[reponse3];
$re_4 = $resultat[reponse4];

	if(!empty($resultat[reponse1]))
        {
        print '<input type="radio" value="1" name="reponse"> '.$resultat[reponse1].'<br>';
        }
        if(!empty($resultat[reponse2]))
        {
        print '<input type="radio" value="2" name="reponse"> '.$resultat[reponse2].'<br>';
        }
        if(!empty($resultat[reponse3]))
        {
        print '<input type="radio" value="3" name="reponse"> '.$resultat[reponse3].'<br>';
        }
        if(!empty($resultat[reponse4]))
        {
        print '<input type="radio" value="4" name="reponse"> '.$resultat[reponse4].'<br>';
        }
}

print '

<br>
<center><input type="image" src="././images/leftnav_log/bouton_voter.gif" alt="Ok" border="0"/>
</form>
</center>

';


?>
</body>

</html>
