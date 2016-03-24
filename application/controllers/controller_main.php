<?php

/**
 * Class Controller_Main
 */
class Controller_Main extends Controller
{
    /**
     * @var string
     */
    private $url = '/visits/insert';
    private $domain;
    /**
     * Action index
     */
    function action_index()
    {
        $this->domain = Gonfiguration::get('url');
        $curl   = new cURL(true, true);
        $result = $curl->post($this->domain . $this->url, ['name' => uniqid()]);

        $this->view->generate('main_view', [
            'id' => $this->getRowId($result)
        ]);
    }

    /**
     * @param $result
     * @return null
     */
    private function getRowId($result)
    {
        if ($result && is_string($result)) {
            $data = json_decode($result, true);

            return (array_key_exists('row_id', $data) ? $data['row_id'] : null);
        }

        return null;
    }
}