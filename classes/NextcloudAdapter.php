<?php

namespace OAuth\Plugin;

class NextcloudAdapter extends AbstractGenericAdapter {
    /**
     * Retrieve the user's data
     *
     * The array needs to contain at least 'user', 'mail', 'name' and optional 'grps'
     *
     * @return array
     */
    public function getUser() {
        $JSON = new \JSON(JSON_LOOSE_TYPE);
        $data = array();


        /** var OAuth\OAuth2\Service\Generic $this->oAuth */
        error_log(print_r($extraHeaders, TRUE), 3, '/var/www/wiki/errors.log');
        $result = $JSON->decode($this->oAuth->request($this->getUrl() . '/ocs/v1.php/cloud/user?format=json'));
        $data['user'] = $result[1]['id'];
        $data['name'] = $result[1]['display-name'];
        $data['mail'] = $result[1]['email'];
        $data['grps'] = $result[1]['groups'];
        return $data;
    }

    public function getAuthEndpoint() {
      return ($this->getUrl() . '/apps/oauth2/authorize');
    }

    public function getTokenEndpoint() {
      return ($this->getUrl() . '/apps/oauth2/api/v1/token');
    }

    protected function getUrl() {
      return $this->hlp->getUrl($this->getAdapterName());
    }
}
