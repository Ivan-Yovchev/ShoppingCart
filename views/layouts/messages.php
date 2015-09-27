<?php

renderMessages(INFO_MESSAGES_SESSION_KEY, 'alert alert-success');
renderMessages(ERROR_MESSAGES_SESSION_KEY, 'alert alert-danger');

function renderMessages($messagesKey, $cssClass) {
    if (isset($_SESSION[$messagesKey]) && count($_SESSION[$messagesKey]) > 0) {
        echo '<ul id="messages">';
        foreach ($_SESSION[$messagesKey] as $msg) {
            echo "<li class=' ". $cssClass ." '>" . htmlspecialchars($msg) . '</li>';
        }
        echo '</ul>';
    }
    $_SESSION[$messagesKey] = [];
}
