<?php

/**
 * Class View
 */
class View
{
    protected $default_template = 'template_view';

    /**
     * @param $content_view
     * @param $template_view
     * @param null $data
     */
    function generate($content_view, $data = null, $template_view = null)
	{
		include 'application/views/' . (is_null($template_view) ? $this->default_template : $template_view) . '.php';
	}
}
