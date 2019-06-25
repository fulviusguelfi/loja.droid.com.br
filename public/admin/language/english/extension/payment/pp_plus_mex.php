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

$_['heading_title']					= 'PayPal Plus México by Treebes';

$_['text_success']					= 'Correcto: &iexcl;Ha modificado PayPal Plus M&eacute;xico by Treebes!';
$_['text_edit']                     = 'Editar PayPal Plus M&eacute;xico by Treebes';
$_['text_pp_plus_mex']				= '<a target="_BLANK" href="https://www.treebes.com/"><img src="view/image/payment/pp_plus_mex_logo.png" alt="Payment - PayPalPlus M&eacute;xico by Treebes" title="PayPalPlus M&eacute;xico by Treebes" style="border: 1px solid #EEEEEE;" /></a>';

$_['text_payment_info']				= 'Informacion Pago';
$_['text_capture_status']			= 'Estado Captura';
$_['text_amount_auth']				= 'Importe autorizado';

$_['text_transactions']				= 'Transacciones';
$_['text_complete']					= 'Completado';

$_['text_view']						= 'Ver';

$_['text_transaction']				= 'Transacción';
$_['text_product_lines']            = 'Lineas Producto';
$_['text_ebay_txn_id']              = 'ID transacci&oacute;n eBay';
$_['text_name']                     = 'Nombre';
$_['text_qty']                      = 'Cantidad';
$_['text_price']                    = 'Precio';
$_['text_number']                   = 'N&uacute;mero';
$_['text_coupon_id']                = 'Cupón ID';
$_['text_coupon_amount']            = 'Cup&oacute;n importe';
$_['text_coupon_currency']          = 'Cup&oacute;n moneda';
$_['text_loyalty_disc_amt']         = 'Importe Tarjeta fidelidad';
$_['text_loyalty_currency']         = 'Moneda Tarjeta fidelidad';
$_['text_options_name']             = 'Opciones nombre';
$_['text_tax_amt']                  = 'Importe impuestos';
$_['text_currency_code']            = 'C&oacute;digo moneda';
$_['text_amount']                   = 'Importe';
$_['text_gift_msg']                 = 'Mensaje del regalo';
$_['text_gift_receipt']             = 'Receptor Regalo';
$_['text_gift_wrap_name']           = 'Regalo Nombre embalaje';
$_['text_gift_wrap_amt']            = 'Regalo Importe embalaje';
$_['text_buyer_email_market']       = 'Email marketing de Comprador';
$_['text_survey_question']          = 'Pregunta de la encuesta';
$_['text_survey_chosen']            = 'Eleccion selecionada encuesta';
$_['text_receiver_business']        = 'Negocio Receptor';
$_['text_receiver_email']           = 'Email Receptor';
$_['text_receiver_id']              = 'Receprtor ID';
$_['text_buyer_email']              = 'Email Comprador';
$_['text_payer_id']                 = 'Pagador ID';
$_['text_payer_status']             = 'Estado Pagador';
$_['text_country_code']             = 'Codigo Pais';
$_['text_payer_business']           = 'Negocio Pagador';
$_['text_payer_salute']             = 'Saludo Pagador';
$_['text_payer_firstname']          = 'Nombre Pagador';
$_['text_payer_middlename']         = 'Pagador segundo nombre';
$_['text_payer_lastname']           = 'Pagador apellido';
$_['text_payer_suffix']             = 'Pagador sufijo';
$_['text_address_owner']            = 'Direccion comprador';
$_['text_address_status']           = 'Estado direccion';
$_['text_ship_sec_name']            = 'Enviar a segundo nombre';
$_['text_ship_name']                = 'Enviar nombre';
$_['text_ship_street1']             = 'Enviar a direccion 1';
$_['text_ship_street2']             = 'Enviar a direccion 2';
$_['text_ship_city']                = 'Enviar a ciudad';
$_['text_ship_state']               = 'Enviar a provincia';
$_['text_ship_zip']                 = 'Enviar a C.Postal';
$_['text_ship_country']             = 'Enviar a Pa&iacute;s c&oacute;digo';
$_['text_ship_phone']               = 'Enviar a telefono';
$_['text_ship_sec_add1']            = 'Enviar a segunda direccion 1';
$_['text_ship_sec_add2']            = 'Enviar a segunda direccion 2';
$_['text_ship_sec_city']            = 'Enviar a segunda ciudad';
$_['text_ship_sec_state']           = 'Enviar a segunda provincia';
$_['text_ship_sec_zip']             = 'Enviar a segunda C. Postal';
$_['text_ship_sec_country']         = 'Enviar a segunda codigo pais';
$_['text_ship_sec_phone']           = 'Enviar a segundo telefono';
$_['text_trans_id']                 = 'Transacci&oacute;n ID';
$_['text_receipt_id']               = 'Receptor ID';
$_['text_parent_trans_id']          = 'Transaccion ID';
$_['text_trans_type']               = 'Tipo Transacci&oacute;n';
$_['text_payment_type']             = 'Tipo de pago';
$_['text_order_time']               = 'Fecha pedido';
$_['text_fee_amount']               = 'Importe de la cuota';
$_['text_settle_amount']            = 'Importe liquidado';
$_['text_tax_amount']               = 'Importe impuestos';
$_['text_exchange']                 = 'Tipo de cambio';
$_['text_payment_status']           = 'Estado pagos';

$_['text_reason_code']              = 'Razón código';
$_['text_protect_elig']             = 'Elegibilidad Protección';
$_['text_protect_elig_type']        = 'Tipo Elegibilidad Protección';
$_['text_store_id']                 = 'Tienda ID';
$_['text_terminal_id']              = 'Terminal ID';
$_['text_invoice_number']           = 'Factura n&uacute;mero';
$_['text_custom']                   = 'Personalizado';
$_['text_note']                     = 'Nota';
$_['text_sales_tax']                = 'Impuesto venta';
$_['text_buyer_id']                 = 'Comprador ID';
$_['text_close_date']               = 'Fecha de cierre';
$_['text_multi_item']               = 'Multi articulo';
$_['text_sub_amt']                  = 'Importe suscripcion';
$_['text_sub_period']               = 'Periodo suscripcion';
$_['text_redirect']					= 'Redirigir';
$_['text_iframe']					= 'Iframe';

$_['help_debug']					= "Registros de informacion adicional.";

$_['column_trans_id']				= 'Transacion ID';
$_['column_amount']					= 'Importe';
$_['column_type']					= 'Tipo de Pago';
$_['column_status']					= 'Estado';
$_['column_pend_reason']			= 'Razon Pendiente';
$_['column_date_added']				= 'Creado';
$_['column_action']					= 'Accion';

$_['tab_settings']					= 'Configuracion';
$_['tab_order_status']				= 'Estado del Pedido';
$_['tab_checkout_customisation']	= 'Personlizacion Pago';
$_['tab_important_message']			= 'IMPORTANTE:<br>Las Credenciales REST habrán de colocarse según se elija el MODO TEST (Sandbox o Live).';
$_['tab_instrucciones']				= 'Instrucciones';

$_['entry_clientid']				= 'REST ClientId';
$_['entry_secret']					= 'REST Secret';
$_['entry_experience_profile_id']	= 'ProfileId';
$_['entry_test']					= 'Modo Test';
$_['entry_total']					= 'Total';
$_['entry_order_status']			= 'Estado del Pedido:';
$_['entry_geo_zone']				= 'Geo Zona:';
$_['entry_status']					= 'Estado:';
$_['entry_sort_order']				= 'Orden:';
$_['entry_transaction_id']			= 'Transacción ID';

$_['entry_amount']					= 'Importe';
$_['entry_message']					= 'Mensaje';
$_['entry_debug']					= 'Modo Debug:';

$_['entry_completed_status']		= 'Estado Pagado:';

$_['help_test']						= 'Utilice el servidor en vivo (live) o test (sandbox) para procesar las transacciones? Las pruebas pueden fallar en Internet Explorer';
$_['help_total']					= 'Importe total necesario para que se active esta forma de pago';

$_['error_permission']				= 'Advertencia: &iexcl;No dispone de permiso para modificar PayPal Plus México by Treebes!';
$_['error_experience_profile_id']	= 'ProfileId requerido!';
$_['error_clientid']				= 'ClientId requerido!';
$_['error_secret']					= 'Secret requerido!';
$_['error_timeout']					= 'Tiempo de espera agotado';
$_['error_transaction_missing']		= 'No se pudo encontrar la transaccion';
$_['error_missing_data']			= 'Faltan datos';
$_['error_general']					= 'Se ha producido un error';

?>