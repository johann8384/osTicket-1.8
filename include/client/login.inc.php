<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');
$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);
?>
<h1>Check Ticket Status</h1>
<p>To view the status of a ticket, provide us with the login details below.</p>
<form action="login.php" method="post" id="clientLogin">
    <?php csrf_token(); ?>
      <div class="control-group">
        <label class="control-label" for="inputName">E-Mail Address:</label>
          <div class="controls">
            <input id="email" type="text" name="lemail" size="30" value="<?php echo $email; ?>" placeholder="Email Address">
          </div>
      </div>
  <div class="control-group">
        <label class="control-label" for="inputName">Ticket ID:</label>
          <div class="controls">
            <input id="ticketno" type="text" name="lticket" size="16" value="<?php echo $ticketid; ?>" placeholder="Ticket Number">
          </div>
    </div>
        <input class="btn btn-primary" type="submit" value="View Status">
</form>
<p>
If this is your first time contacting us or you've lost the ticket ID, please <a href="open.php">open a new ticket</a>.    
</p>
