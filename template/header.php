<h3>Site Header</h3>








<?php
        if (isset($flashMessage) && $flashMessage) {
            $messageClass = ($flashMessage['messageType']) ? 'alert-info' : 'alert-danger';
            ?>
            <div class="alert <?php echo $messageClass; ?>">
            <?php
            echo $flashMessage['message'];
            ?>
            </div>
<?php } ?>