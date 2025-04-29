<?php  if ( ! defined('__NAJZMI_PUDINTEA__')) exit('No direct script access allowed');
/**
*
* Author:  Pudin S I
* 		   najzmitea@gmail.com
*
*/

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Guzzle_Models extends CI_Model
{
    	private $_username;
	private $_password;
   	private $_biotime_url;
	function __construct(){
		parent::__construct();
			$this->_username = 'usernamexxx';
			$this->_password = 'passwordxxx';
      			$this->_biotime_url = 'http://xxxxxxxxxxx';
	}
	
	/**
     * return _retval
     *
     * @var Boolean
     **/
    private $_retval = NULL;

    /**
     * return _result
     *
     * @var Boolean
     **/
    private $_result = FALSE;

    /**
     * return _retarr
     *
     * @var Array
     **/
    private $_retarr = array();

    function get_auth(){
        $client = new Client();
        try {
            $response = $client->request('POST', $this->_biotime_url.'/jwt-api-token-auth/', [
				'headers' => ['Content-Type' => 'application/json'],
				'json' => [
					'username' => $this->_username,
					'password' => $this->_password
				]
			]);

            // Tampilkan response body
            $hasil =  $response->getBody();
        } catch (ClientException $e) {
            // Tampilkan pesan error lebih detail
            $hasil = $e->getResponse()->getBody()->getContents();
        }
		
		$result = json_decode($hasil, true);
		return $result['token'];
    }
}
