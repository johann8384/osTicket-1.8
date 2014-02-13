<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');
$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
      <div class="hero-unit">
        <h1>Welcome to the Support Center</h1><br>
        <p>In order to streamline support requests and better serve you, we utilize a support ticket system. Every support request is assigned a unique ticket number which you can use to track the progress and responses online. For your reference we provide complete archives and history of all your support requests. A valid email address is required to submit a ticket.</p>
        <p><a href="open.php" class="btn btn-primary btn-large">Open New Ticket &raquo;</a></p>
      </div>
<br>
    <div class="row">
      <div class="span1">
        <a href="open.php"> <img src="img/new_ticket_icon.png"></a>
      </div>
      <div class="span5">
      <h3>Open A New Ticket</h3>
        <p>Please provide as much detail as possible so we can best assist you. To update a previously submitted ticket, please login. <br><br><a href="open.php" class="btn">Open a New Ticket</a></p>
        
        </div>
      <div class="span1">
        <a href="login.php"> <img src="img/check_status_icon.png"></a>
      </div>
      <div  class="span5">
        <?php
          if($thisclient && is_object($thisclient) && $thisclient->isValid()) {
             ?>
          <h3>Check Your Tickets</h3>
          <p>Check the status of all your current tickets. </p>
          <a href="tickets.php" class="btn">View All Tickets</a>
          <?php
          } else {
        ?>
        <h3>Check Ticket Status</h3>
          <div class="control-group">
              <div class="controls">
                <form action="login.php" method="post" id="clientLogin">
                  <?php csrf_token(); ?>
                <input id="email" type="text" name="lemail" size="30" value="<?php echo $email; ?>" placeholder="Email Address"> <br>
                <input id="ticketno" type="text" name="lticket" size="16" value="<?php echo $ticketid; ?>" placeholder="Ticket Number"> <br>
                <input class="btn" type="submit" value="View Status">
                </form>
              </div>
          </div>
          <?php } ?>
        </div>
      </div>
<?php
if($cfg && $cfg->isKnowledgebaseEnabled()){
    //FIXME: provide ability to feature or select random FAQs ??
?>
<br> <br>
<p class="text-center">Be sure to browse our <a href="kb/index.php">Frequently Asked Questions (FAQs)</a>, before opening a ticket.</p>
<?php
} ?>
<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
