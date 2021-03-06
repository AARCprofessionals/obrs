<?
	require 'nusoap/nusoap.php';
		
	class imisConnector
	{
		function endsWith($haystack, $needle)
		{
			$length = strlen($needle);
			if ($length == 0) {
				return true;
			}

			return (substr($haystack, -$length) === $needle);
		}

        private $baseUrl;
		private $url;
		private $client;
		
		public $error;
		
		function imisConnector ($url)
		{
			if (!$this->endsWith($url, '/'))
				$url .= '/';

            $this->baseUrl = $url;
			$url .= 'AsiCommon/Services/Membership/MembershipWebService.asmx?WSDL';			
			$this->url = $url;
			$this->client =  new nusoap_client($url, true);
			$this->client->setUseCurl(true);
			$this->client->useHTTPPersistentConnection();
		}

        function getForgotPasswordUrl()
        {
            return $this->baseUrl;
        }

        function getCreateAccountUrl()
        {
            return $this->baseUrl;
        }

        function doSingleSignOn($username, $password, $url = '')
        {
            //just redireect to next url
        }
		
		function authenticate($username, $password)
		{
            $result = $this->client->call('ValidateUser', array('username'=> $username, 'password'=>$password));
            $this->error = null;
            if (!$result)
            {
                $this->error = "Could not connect to iMIS at ". $this->url;
                return;
            }

            if ($result['ValidateUserResult'] == 'true')
            {
                return $this->getRolesForUser($username, $password);
            }

            return false;
		}
		
		private function getRolesForUser($username, $password)
		{
			$result = $this->client->call('GetRolesWithLogin', array('loginAsUser'=> $username, 'loginPassword'=>$password));				
				
				$this->error = null;
				if (!$result) 
				{
					$this->error = "Could not connect to iMIS at ". $this->url;
					return;
				}				
				
				$response = array();
				
				foreach($result['GetRolesWithLoginResult']['string'] as $k => $v)
				{					
					if (!(preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', strtoupper($v))))
						array_push($response, $v);
				}
				
				array_push($response, 'Authenticated User');				
				sort($response);				
				return $response;		
		}
		
	    function getRoles()
		{
			$result = $this->client->call('GetRoles', array());				
				
				$this->error = null;
				if (!$result) 
				{
					$this->error = "Could not connect to iMIS at ". $this->url;
					return;
				}				
				
				$response = array();
				
				foreach($result['GetRolesResult']['string'] as $k => $v)
				{					
					if (!(preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', strtoupper($v))))
						array_push($response, $v);
				}
				
				array_push($response, 'Authenticated User');
				sort($response);

            $roleDictionary = array();

            foreach($response as  $v)
            {
                    $roleDictionary[$v] = $v;
            }

				return $roleDictionary;
        }
    }
?>