<?php
$template = <<<THEVERYENDOFYOU
<table width="100%">
<tr><td class="title"><img src="images/maison.gif" alt="La maison de {{name}}" title="La maison de {{name}}" /></td></tr>
<tr><td>
<ul>
&nbsp;<img src="././images/site/pic2.gif" /><a href="index.php?do=reposhome"> Se reposer à la maison</a><br>
&nbsp;<img src="././images/site/pic2.gif" /><a href="index.php?do=bierrehome"> Boire une bierre</a><br>
&nbsp;<img src="././images/site/pic2.gif" /><a href="index.php?do=msg"> Laisser un message</a><br>
&nbsp;<img src="././images/site/pic2.gif" /><a href="index.php?do=admin_maison"> Administrer ta maison</a><br>
</ul>
</td></tr>
<tr><td><img src="././images/blog.gif" /><br>
{{bloghome}}

<br />
</td></tr>
</table>
THEVERYENDOFYOU;
?>