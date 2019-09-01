<?php
    session_start();

    /**
     * Flash message helper
     * Default name and message is empty string,
     * Default class (bootstrap) is alert alert-success
     * To display in view use <?php echo flash($nameOfFlash); ?>
     * 
     * e.g. call flash('success', 'You did it'); in controller php code
     * then in view call <?php echo flash('success'); ?>
     */
    function flash($name = '', $message = '', $class = 'alert alert-success') {
        if(!empty($name)) {
            if(!empty($message) && empty($_SESSION[$name])) {
                if(!empty($_SESSION[$name])) {
                    unset($_SESSION[$name]);
                }
                if(!empty($_SESSION[$name . '_class'])) {
                    unset($_SESSION[$name . '_class']);
                }

                // Save message associated to name e.g. 'success' => 'You did it'
                $_SESSION[$name] = $message;
                // Save class type to session e.g. 'success_class'
                $_SESSION[$name . '_class'] = $class;
            } elseif(empty($message) && !empty($_SESSION[$name])) {
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
                echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }

    
    /**
     * Check if user is logged in
     * return: true if logged in, false otherwise
     */
    function isLoggedIn() {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }