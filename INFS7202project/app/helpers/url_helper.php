<?php
    /**
     * Simple page redirection function
     * e.g. redirect('home/index)
     */
    function redirect($page) {
        header('location: '. URLROOT . '/'. $page);
    }