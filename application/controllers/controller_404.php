<?php

/**
 * Class Controller_404
 */
class Controller_404 extends Controller
{

    /**
     * Action index
     */
    function action_index()
    {
        $this->view->generate('404_view.php', 'template_view');
    }

}
