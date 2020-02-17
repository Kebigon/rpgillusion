<?php
$template = <<<THEVERYENDOFYOU
<head>
<title>Boite de dialogue</title>
<style type="text/css">
body {
  background-image: url(images/site/background.jpg);
  color: black;
  font: 11px verdana;
  margins: 0px;
  padding: 0px;
}
div {
    padding: 2px;
    border: solid 1px black;
    margin: 2px;
    text-align: left;
}
a {
    color: #663300;
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    color: #330000;
}
</style>
</head>
<body onload="window.scrollTo(0,99999)">
{{content}}
<center><A HREF="#" onClick="window.open('smile.php','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=500, height=100');return(false)">Smile et Bbcode</A><br /></td></tr> 

</body>
</html>
THEVERYENDOFYOU;
?>