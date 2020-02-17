// Affichier la bannière en flash

function Flash(swf, hauteur, largeur, couleur, nom, mavariable) {
document.write("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\""+hauteur+"\" height=\""+largeur+"\" id=\""+nom+"\" align=\"middle\">\n");
document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />\n");
document.write("<param name=\"movie\" value=\""+swf+"\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\""+couleur+"\" /><param name=\"FlashVars\" value=\"session="+mavariable+"\" /><embed src=\""+swf+"\" FlashVars=\"session="+mavariable+"\" quality=\"high\" bgcolor=\""+couleur+"\" width=\""+hauteur+"\" height=\""+largeur+"\" name=\""+nom+"\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />\n");
document.write("</object>\n");
}

//Fonction pour l'affichage du classement objets.

function classement(thingId)
{
 var i;
 var targetElement;
 for(i=1; i<4; i++){
  targetElement = document.getElementById("divid" + i) ;
  targetElement.style.display = "none" ;
 }
 targetElement = document.getElementById("divid" + thingId) ;
 targetElement.style.display = "" ;
}
