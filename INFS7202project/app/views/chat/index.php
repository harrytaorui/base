<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <h1 class="text-center">Live Chatroom</h1>

    <div class="row my-3">
        <div id="chat_output" class="col-8 mx-auto border border-primary"></div>
        <textarea id="chat_input" class="col-8 mx-auto mt-3" cols="100" rows="5"></textarea>
    </div>

</div>


<?php require APPROOT . '/views/includes/footer.php'; ?>


<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/chat/chat.css">

<?php 
    if(isset($_SESSION['user_name'])) {
        $myId = $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
    } else {
        $myId = mt_rand(1,999);
        $userName = "Guest" . $myId;
    }
?>

<script type="text/javascript">
    // document on ready
    jQuery(function($){
        // Create websocket connection
        var websocketServer = new WebSocket("ws://localhost:8080/");
        // Setup connection to websocket server
        websocketServer.onopen = function(event) {
            websocketServer.send(JSON.stringify({'type':'socket','user_id':<?php echo $myId; ?>}));
        };
        // Handle incoming message
        websocketServer.onmessage = function(event) {
            var json = JSON.parse(event.data);
            switch(json.type) {
                case 'message':
                    $('#chat_output').append(json.msg);
                    // Move scroll to bottom
                    $('#chat_output').scrollTop($('#chat_output').prop('scrollHeight'));
                    break;
            }
        };
        // Handle error
        websocketServer.onerror = function(event) {

        };

        /**
         * Handle sending message to server
         * Message format:
         *      {
         *          'type': 'message',
         *          'user_id': username or guest
         *          'chatMessage': 'message entered by user'
         *      }
         */
        $('#chat_input').on('keyup',function(e){
            // If user pressed ENTER and not (SHIFT + ENTER)
            if(event.keyCode==13 && !event.shiftKey){
                var chat_msg = $(this).val();
                // console.log('sending...');
                websocketServer.send(
                    JSON.stringify({
                        'type':'message',
                        'user_id':"<?php echo $userName; ?>",
                        'chatMessage':chat_msg
                    })
                );
                // Reset text area
                $(this).val('');
            }
        });
    });
</script>