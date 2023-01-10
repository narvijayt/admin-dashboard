<?php

namespace App\Library;

use Illuminate\Support\Facades\Http;

/**
 * Manage API Calls Endpoints
 * 
 * @since 1.0
 */
class ScoringEngine{

    /**
     * HTTP API URL
     * 
     * @access private
	 * @var    string
     */
    private $api_url = "http://mt-scoring-staging.us-east-1.elasticbeanstalk.com";
    
    
    /**
     * HTTP API URL
     * 
     * @access private
	 * @var    string
     */
    private $endpoint_url;

    /**
	 * HTTP Request API version.
	 *
	 * @access private
	 * @var    string
	 */
	private $version;

	/**
	 * HTTP Request Headers.
	 *
	 * @access private
	 * @var    array
	 */
	private $headers;
	
    /**
	 * HTTP Request Resource Type.
	 *
	 * @access private
	 * @var    string
	 */
	private $resource_type;
    
    
    /**
	 * HTTP Request Resource ID.
	 *
	 * @access private
	 * @var    string
	 */
	private $url_params;
    
    
    /**
	 * HTTP Request Query String Params.
	 *
	 * @access private
	 * @var    string
	 */
	private $url_query_string;
    
    
    /**
	 * HTTP Request Type.
	 *
	 * @access private
	 * @var    string
	 */
	private $http_request_method;
    
    
    /**
	 * HTTP Request Body.
	 *
	 * @access private
	 * @var    string
	 */
	private $request_body;

    /**
     * Define default variables and values 
     * 
     * @since 1.0
     */
    public function __construct(){
        // $this->_addHeaders();
    }

    /**
     * HTTP GET API Request
     * 
     * @since 1.0
     * 
     * @param $args = Array or Object
     *        $debug = bool | default is false      
     * 
     * @return $response | success or false
     */
    public function _getRequest($args, $debug = false){

		// Set Headers
		$this->_addHeaders();

        // Set Endpoint URL
        $this->_setServiceEndpointURL($args);
		
        // Add Request Body
        $this->_addRequestBody($args);

        $response = Http::withHeaders($this->headers)->accept('application/json')->retry(3, 100)->get($this->endpoint_url, $this->request_body);
		if($debug == true){
			pr($args);
			echo $this->endpoint_url.'<br/>';
			pr($this->headers);
			pr($this->request_body);
			pr($response->json());
			pr($response->headers());
			die;
		}
        return $response->json();
    }


    /**
     * HTTP POST API Request
     * 
     * @since 1.0
     * 
     * @param $args = Array or Object
     *        $debug = bool | default is false      
     * 
     * @return $response | success or false
     */
    public function _postRequest($args, $debug = false){

		// Set Headers
		$this->_addHeaders();
		
		// Set Endpoint URL
        $this->_setServiceEndpointURL($args);
		
        // Add Request Body
        $this->_addRequestBody($args);

        $response = Http::withHeaders($this->headers)->accept('application/json')->retry(3, 100)->post($this->endpoint_url, $this->request_body);
		if($debug == true){
			pr($args);
			echo $this->endpoint_url.'<br/>';
			pr($this->headers);
			pr($this->request_body);
			pr($response->json());
			pr($response->headers());
			die;
		}
        return $response->json();
    }


    /**
     * HTTP PUT API Request
     * 
     * @since 1.0
     * 
     * @param $args = Array or Object
     *        $debug = bool | default is false      
     * 
     * @return $response | success or false
     */
    public function _putRequest($args, $debug = false){
		// Set Headers
		$this->_addHeaders();

        // Set Endpoint URL
        $this->_setServiceEndpointURL($args);
		
        // Add Request Body
        $this->_addRequestBody($args);

        $response = Http::withHeaders($this->headers)->accept('application/json')->retry(3, 100)->put($this->endpoint_url, $this->request_body);
		if($debug == true){
			pr($args);
			echo $this->endpoint_url.'<br/>';
			pr($this->headers);
			pr($this->request_body);
			pr($response->json());
			pr($response->headers());
			die;
		}
        return $response->json();
    }


    /**
     * HTTP Delete API Request
     * 
     * @since 1.0
     * 
     * @param $args = Array or Object
     *        $debug = bool | default is false      
     * 
     * @return $response | success or false
     */
    public function _deleteRequest($args, $debug = false){

    }


    /**
     * HTTP Patch API Request
     * 
     * @since 1.0
     * 
     * @param $args = Array or Object
     *        $debug = bool | default is false      
     * 
     * @return $response | success or false
     */
    protected function _patchRequest($args, $debug = false){

    }

    /**
     * HTTP Request Headers
     * 
     * @since 1.0
     * 
     */
    private function _addHeaders(){

        $this->headers['Content-Type'] = 'application/json';
        if(session()->has('access_token')){
            $this->headers['Authorization'] = session()->get('access_token');
        }
    }

    /**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _setServiceEndpointURL($args) {

		$this->_resetEndpoints();

		if(!isset($args['service']) || empty($args['service'])){
			return false;
		}

		$this->resource_type = $args['service'];
		
		$this->_addQueryStringParams($args);

		//Set API Endpoint URL
		$this->_setAPIEndpointURL();
	}

    /**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access private
	 * @return array All defined column defaults.
	 */
	private function _resetEndpoints() {

		$this->url_params = '';
		$this->url_query_string = '';
	}


    /**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access private
	 * @return array All defined column defaults.
	 */
	private function _setAPIEndpointURL() {

		$endpoint_url = $this->api_url;

		// $endpoint_url = (empty($this->port)) ? $endpoint_url : $endpoint_url.':'.$this->port;

		$endpoint_url = (empty($this->resource_type)) ? $endpoint_url : $endpoint_url.'/'.$this->resource_type;
		
		$endpoint_url = (empty($this->url_params)) ? $endpoint_url : $endpoint_url.'/'.$this->url_params;

		$this->endpoint_url = (empty($this->url_query_string)) ? $endpoint_url : $endpoint_url.'?'.$this->url_query_string;
	}

    /**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _addQueryStringParams($args) {

		$this->url_query_string = '';
		if(isset($args['query_string']) && !empty($args['query_string'])){
			if(is_array($args['query_string']) || is_object($args['query_string'])){
				if(isset($args['query_string']['limit'])){
					
					$this->url_query_string .= 	"$"."limit=".$args['query_string']['limit'];
					unset($args['query_string']['limit']);
				}
				if(isset($args['query_string']['sort'])){
					if(is_array($args['query_string']['sort'])){
						foreach($args['query_string']['sort'] as $key=>$value){
							$this->url_query_string .= 	!empty($this->url_query_string) ? "&$"."sort[".$key."]=".$value : "$"."sort[".$key."]=".$value;
						}
					}
					unset($args['query_string']['sort']);
				}
				$this->url_query_string .= http_build_query($args['query_string']);
			}else{
				$this->url_params = $args['query_string'];
			}
		}
	}

    /**
	 * Retrieves api endpoint url.
	 *
	 * generates the endpoint URL to call the api url.
	 *
	 * @access public
	 * @return array All defined column defaults.
	 */
	public function _addRequestBody($args){

		if(isset($args['service'])){
			unset($args['service']);
		}
		if(isset($args['query_string'])){
			unset($args['query_string']);
		}

		$this->request_body = $args;
	}
}