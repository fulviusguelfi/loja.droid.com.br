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
?>
<h2><?php echo $text_payment_info; ?></h2>
<table class="table table-striped table-bordered">
  <tr>
    <td><?php echo $text_capture_status; ?></td>
    <td id="capture_status"><?php echo $paypal_order['capture_status']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_amount_auth; ?></td>
    <td><?php echo $paypal_order['total']; ?></td>
  </tr>
  <tr>
    <td><?php echo $text_transactions; ?>:</td>
    <td><table class="table table-striped table-bordered" id="paypal_transactions">
        <thead>
          <tr>
            <td class="text-left"><strong><?php echo $column_trans_id; ?></strong></td>
            <td class="text-left"><strong><?php echo $column_amount; ?></strong></td>
            <td class="text-left"><strong><?php echo $column_type; ?></strong></td>
            <td class="text-left"><strong><?php echo $column_status; ?></strong></td>
            <td class="text-left"><strong><?php echo $column_date_added; ?></strong></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($transactions as $transaction) { ?>
          <tr>
            <td class="text-left"><?php echo $transaction['transaction_id']; ?></td>
            <td class="text-left"><?php echo $transaction['amount']; ?></td>
            <td class="text-left"><?php echo $transaction['payment_type']; ?></td>
            <td class="text-left"><?php echo $transaction['payment_status']; ?></td>
            <td class="text-left"><?php echo $transaction['date_added']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table></td>
  </tr>
</table>
