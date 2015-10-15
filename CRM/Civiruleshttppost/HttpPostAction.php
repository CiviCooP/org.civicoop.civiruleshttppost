<?php

class CRM_Civiruleshttppost_HttpPostAction extends CRM_Civirules_Action {

  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    //do the http post process
    $uri = $this->getUri();
    $method = $this->getHttpMethod();
    $body = $this->getRequestBody();
    switch (strtolower($method)) {
      case 'post':
        $request = \Httpful\Request::post($uri, $body);
        break;
      case 'put':
        $request = \Httpful\Request::put($uri, $body);
        break;
      case 'delete':
        $request = \Httpful\Request::delete($uri);
        break;
      case 'head':
        $request = \Httpful\Request::head($uri);
        break;
      case 'patch':
        $request = \Httpful\Request::patch($uri, $body);
        break;
      case 'options':
        $request = \Httpful\Request::options($uri, $body);
        break;
      case 'get':
        $request = $response = \Httpful\Request::get($uri);
        break;
      default:
        throw new Exception('Invalid HTTP Method');
    }

    $request = $this->alterHttpRequestObject($request);
    $response = $request->send();
    $this->handleResponse($response);
  }

  /**
   * Handle the response returned by the server
   *
   * Child classes could override this method to do something with the response.
   * By default this class throws an exception when the response has han error
   *
   * @param \Httpful\Response $response
   * @throws \Exception
   */
  protected function handleResponse(\Httpful\Response $response) {
    //by default throw an error if response is not a 200 response
    if ($response->hasErrors()) {
      throw new Exception('Invalid response. Got a HTTP '.$response->code."\r\n\r\n".$response->raw_headers."\r\n\r\n".$response->raw_body);
    }
    //do something with the response. You could override this method in a child class to do something with the response.
  }

  /**
   * Alter the request object before it is send to the web service
   *
   * child classes could override this method to set extra headers and options
   * on the request object
   *
   * @param \Httpful\Request $request
   * @return \Httpful\Request
   */
  protected function alterHttpRequestObject(\Httpful\Request $request) {
    return $request;
  }

  /**
   * Returns a valid http method
   *
   * @return string
   */
  protected function getHttpMethod() {
    $params = $this->getActionParameters();
    return $params['http_method'];
  }

  /**
   * Returns the URI to call
   *
   * @return string
   */
  protected function getUri() {
    $params = $this->getActionParameters();
    return $params['uri'];
  }

  /**
   * Returns the body to send with the request
   *
   * @return string
   */
  protected function getRequestBody() {
    $params = $this->getActionParameters();
    return $params['request_body'];
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a action
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleActionId
   * @return bool|string
   * $access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirules/action/form/http_post_action', 'rule_action_id='.$ruleActionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    return 'Calls '.$this->getUri();
  }

}