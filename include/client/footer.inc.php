  <hr>
    <footer>
      <p>Powered by <a href="http://osticket.com" target="_blank" title="osTicket">osTicket</a> - Theme by <a href="http://www.fantasypc.com" target="_blank" title="FantasyPC">FantasyPC</a></p>
    </footer>
  </div>

<!-- Modal -->
<div id="myLogin" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Check Ticket Status</h3>
  </div>
  <div class="modal-body">
    <form action="login.php" method="post" id="clientLogin">
    <?php csrf_token(); ?>
      <div class="control-group">
          <div class="controls">
            <input id="email" type="text" name="lemail" size="30" value="<?php echo $email; ?>" placeholder="Email Address"> <br>
            <input id="ticketno" type="text" name="lticket" size="16" value="<?php echo $ticketid; ?>" placeholder="Ticket Number"> <br>
          </div>
      </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <input class="btn" type="submit" value="View Status">
    </form>
  </div>
</div>

  <script src="http://code.jquery.com/jquery.js"></script>
  <script src="<?php echo ROOT_PATH; ?>js/bootstrap.min.js"></script>

</body>
</html>