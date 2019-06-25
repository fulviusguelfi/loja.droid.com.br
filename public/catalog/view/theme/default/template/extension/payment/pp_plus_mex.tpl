<?php
/*
Payment Method PayPalPlus México by Treebes
Author: Juan Lanzagorta FV
www.treebes.com
Ver 1.0 
15 November 2017

Code is distributed as is.
It is not permited to re-distribute this code.

Support only available for buyers in our database,
via email soporte@treebes.com and having available
support hours in the included support contract.

NOTES:
+ Only available for Mexican Pesos (MXN)
+ Only available for Mexican Credit Cards
+ Only one status of payment is managed (no cancelation, no refund, no resend, no re-authorise, etc.)

Treebes nor the Authors ARE NOT responsible for the use or consecuences of the use of this code.
*/
if (!$error_connection) {
  echo $code;
} else {
  echo '<div class="warning">'.$error_connection.'</div>';
}
?>