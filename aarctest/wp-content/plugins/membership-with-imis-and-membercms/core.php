<?php
session_start();
require('inc/imis.php');
require('inc/NonprofitCmsApi.php');

class WordPressMembership
{
    private $client;

    function WordPressMembership($type, $url, $key = '')
    {
        if ($type == 'iMIS 15')
        {
            $this->client = new imisConnector($url);
        }
        else if ($type == 'MemberCMS')
        {
            $this->client =  new NonprofitCmsApi($key, $url);
        }
    }

    /**
     * Returns roles array of logged in user or false
     * @param $username
     * @param $password
     */
    function authenticate($username, $password)
    {
        $response = $this->client->authenticate($username, $password);
        if ($response != false) {
            $_SESSION['npcms_auth_user'] = Array();
            $_SESSION['npcms_auth_user']['roles'] = $response;
            return true;
        }
        return false;
    }

    function getAllRoles()
    {
        if (!$this->client)
            return;

        return $this->client->getRoles();
    }

    function getResetPasswordUrl()
    {
        if (!$this->client)
            return;

        return $this->client->getForgotPasswordUrl();
    }

    function getCreateAccountUrl()
    {
        if (!$this->client)
            return;

        return $this->client->getCreateAccountUrl();
    }

    function doSingleSignOn($username, $password, $url = '')
    {
        if (!$this->client)
            return;

        return $this->client->doSingleSignOn($username, $password, $url);
    }

    function isUserLoggedIn() {
        if (!$this->client)
            return;

        return isset($_SESSION['npcms_auth_user']);
    }

    function logoutUser() {
        if (!$this->client)
            return;

        unset($_SESSION['npcms_auth_user']);
    }

    function userInRole($selectedRoles) {
        if (!$this->client)
            return;

        $rolesForUser = $_SESSION['npcms_auth_user']['roles'];
        foreach($rolesForUser as $role) {
            if (in_array($role, $selectedRoles)) {
                return true;
            }
        }
        return false;
    }
}

?>