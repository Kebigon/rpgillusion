<?php
$template = <<<THEVERYENDOFYOU
<table border="0" width="61">

    <tr>
        <img src="images/title_fighting.gif"/><br><br>
        <td width="359" height="121" background="images/bb03.png">
            <table border="0" width="359" align="center">
                <tr>
                    <td width="118" height="149" align="center" valign="bottom">
                        <p align="center">&nbsp;</p>
                        <p align="center"><img src="images/avatar/{{image2}}"  style="vertical-align: top; "></p>
                        <p align="center">&nbsp;</p>
						</td>
                    <td width="86" height="149">
                        <p>&nbsp;</p>
                    </td>
                    <td width="133" height="149" valign="bottom">
                        <p align="center">&nbsp;</p>
						<p align="center">&nbsp;</p>
                        <p align="center"><img src="images/monstre/{{image}}.gif"  style="vertical-align: top; "></p>
                        <p align="center">&nbsp;</p>
                    </td>
                </tr>
            </table>
        </td>
        
           <p><p> Vous combattez un :  <b>{{monstername}}</b> .<b><br>&nbsp;</b>De 
            level :&nbsp;<b>{{levelmonstre}}</b> .<br>Avec : <b>{{monsterhp}}</b> 
            de vie .<br>{{immunecontre}}</p>
        </td>
    </tr>
    <tr>
        <td width="0" height="275">
            <p>&nbsp;</p>
        </td>
        
            {{yourturn}} {{monsterturn}}</p>
        
        
            {{command}}</p>
        </td>
    </tr>
</table>
THEVERYENDOFYOU;
?>

