<?php
require_once 'csrest.php';

/**
 * Class to access a templates resources from the create send API. 
 * This class includes functions to create update and delete templates
 * @author tobyb
 *
 */
class CS_REST_Templates extends CS_REST_Wrapper_Base {	
	
	/**
	 * The base route of the lists resource.
	 * @var string
	 * @access private
	 */
	var $_templates_base_route;
	
	/**
	 * Constructor. 
	 * @param $list_id string The template id to access (Ignored for create requests)
	 * @param $api_key string Your api key (Ignored for get_apikey requests)
	 * @param $protocol string The protocol to use for requests (http|https)
	 * @param $debug_level int The level of debugging required CS_REST_LOG_NONE | CS_REST_LOG_ERROR | CS_REST_LOG_WARNING | CS_REST_LOG_VERBOSE
	 * @param $host string The host to send API requests to. There is no need to change this
	 * @param $log CS_REST_Log The logger to use. Used for dependency injection
	 * @param $serialiser The serialiser to use. Used for dependency injection
	 * @param $transport The transport to use. Used for dependency injection
	 * @access public
	 */
	function CS_REST_Templates (
		$template_id,
		$api_key, 
		$protocol = 'https', 
		$debug_level = CS_REST_LOG_NONE,
		$host = 'api.createsend.com', 
		$log = NULL,
		$serialiser = NULL, 
		$transport = NULL) {
		$this->CS_REST_Wrapper_Base($api_key, $protocol, $debug_level, $host, $log, $serialiser, $transport);
		$this->_templates_base_route = $this->_base_route.'templates/'.$template_id.
		    '.'.$this->_serialiser->get_format();		
	}
	
	function create($client_id, $template_details, $call_options = array()) {
		$list_details = $this->_serialiser->format_item('Template', $template_details);
		
		$call_options['route'] = $this->_base_route.'templates/'.$client_id.'.'.$this->_serialiser->get_format();
		$call_options['method'] = CS_REST_POST;
		$call_options['data'] = $this->_serialiser->serialise($template_details);
		
		return $this->_call($call_options);		
	}
	
	function update($template_details, $call_options = array()) {
		$list_details = $this->_serialiser->format_item('Template', $template_details);
		
		$call_options['route'] = $this->_templates_base_route;
		$call_options['method'] = CS_REST_PUT;
		$call_options['data'] = $this->_serialiser->serialise($template_details);
		
		return $this->_call($call_options);		
	}
	
	function delete($call_options = array()) {
		$call_options['route'] = $this->_templates_base_route;
		$call_options['method'] = CS_REST_DELETE;
		
		return $this->_call($call_options);
	}
	
	function get($call_options = array()) {
		$call_options['route'] = $this->_templates_base_route;
		$call_options['method'] = CS_REST_GET;
		
		return $this->_call($call_options);		
	}
}