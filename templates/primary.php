<?php
$template = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>{{rpgname}} - {{title}}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
{{styles}}
</head>
<body {{load_classement}}>

<div id="conteneur">

<div id="header"> </div>

<div id="flash"><script type="text/javascript">Flash("images/principal/entete8.swf", "767", "46", "", "banniere", "$mavariable" );</script></div>

<div>

<div id="centre">

<div id="menu">
  {{leftnav}}{{leftnavlog}}
  </div>
  <div id="contenu">
  {{content}}<br><br>
  </div>
  </div>

  </div>
  <div id="pied">
  <span class="taille1">{{copyright}}</span>&nbsp;&nbsp;
  </div>
  </div>
</body>
</html>
';
?>