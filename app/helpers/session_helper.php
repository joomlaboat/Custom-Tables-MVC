<?php

session_start();

// Flash message helper

// EXAMPLE - flash('register_success', $message = 'You are now registered', 'alert alert-danger')
// DISPLAY IN VIEW - echo flash('register_success');
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)) {
        if (!empty($message) and empty($_SESSION[$name])) {

            if(!empty($_SESSION[$name])){
                unset($_SESSION[$name]);
            }

            if(!empty($_SESSION[$name . '_class'])){
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        }elseif (empty($message) and !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

//$_SESSION['user'] = null;


function isLoggedIn()
{
    if(isset($_SESSION['user_id'])) {
        return true;
    }else{
        return false;
    }
}