import style from '../css/app.css';

require('./bootstrap');

require('./main/app.js');

require('./admin/admin.js');
require('./admin/adminController.js');

require('./home/home.js');
require('./home/homeController.js');
require('./home/homeService.js');

require('./auth/auth.js');
require('./auth/authService.js');
require('./auth/loginController.js');

require('./master/master.js');
require('./master/masterService.js');

require('./ship/ship.js');
require('./ship/shipService.js');
require('./ship/shipController.js');
require('./ship/editShipController.js');
require('./ship/addShipController.js');

require('./sender/sender.js');
require('./sender/senderService.js');
require('./sender/senderController.js');
require('./sender/addSenderController.js');
require('./sender/editSenderController.js');

require('./recipient/recipient.js');
require('./recipient/recipientService.js');
require('./recipient/recipientController.js');
require('./recipient/addRecipientController.js');
require('./recipient/editRecipientController.js');

require('./bapb/bapb.js');
require('./bapb/bapbService.js');
require('./bapb/bapbController.js');
require('./bapb/containerController.js');
require('./bapb/inputBapbController.js');

require('./invoice/invoice.js');
require('./invoice/invoiceService.js');
require('./invoice/invoiceController.js');
require('./invoice/inputInvoiceController.js');

require('./payment/payment.js');
require('./payment/paymentService.js');
require('./payment/paymentController.js');
