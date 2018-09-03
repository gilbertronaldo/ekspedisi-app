require('./bootstrap');

require('./main/app.js');

require('./admin/admin.js');
require('./admin/adminController.js');

require('./home/home.js');
require('./home/homeController.js');

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
require('./bapb/inputBapbController.js');
