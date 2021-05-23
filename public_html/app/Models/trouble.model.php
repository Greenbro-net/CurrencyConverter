<?php

class Trouble 
{
    public function show404()
    {
        echo "
        <section id=\"page_404\" class=\"cases-links\">
        <h2 class=\"error-404\"> 404 Page not found!</h2>
        <p class=\"error-404-p\">Page doesn't exist!
        Click 
        <a href=\"http://currency_converter.com/\"> here </a>to return on the main page.<br>
        If you are here after click on some link please told us that we can fix that issue:)</p>
        </section>
        ";
    }
}