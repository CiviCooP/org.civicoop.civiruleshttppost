<?php

class CRM_Civiruleshttppost_HttpPostAction extends CRM_Civirules_Action {

  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    //do the http post process
    $uri = $this->replaceUriTokens($triggerData);
    $method = $this->getHttpMethod();
    $body = $this->replaceRequestBodyTokens($triggerData);
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

    $request = $this->alterHttpRequestObject($request, $triggerData);
    $response = $request->send();
    $this->handleResponse($response, $triggerData);
  }

  protected function replaceUriTokens(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    return $this->replaceTokens($this->getUri(), $triggerData->getContactId());
  }

  protected function replaceRequestBodyTokens(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    return $this->replaceTokens($this->getRequestBody(), $triggerData->getContactId());
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
  protected function handleResponse(\Httpful\Response $response, CRM_Civirules_TriggerData_TriggerData $triggerData) {
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
  protected function alterHttpRequestObject(\Httpful\Request $request, CRM_Civirules_TriggerData_TriggerData $triggerData) {
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

  protected function replaceTokens($input, $contact_id) {
    //get contact
    $params = array(array('contact_id', '=', $contact_id, 0, 0));
    list($contact, $_) = CRM_Contact_BAO_Query::apiQuery($params);
    $contact = reset($contact);
    if (!$contact || is_a($contact, 'CRM_Core_Error')) {
      throw new API_Exception('Could not find contact with ID: ' . $params['contact_id']);
    }

    $tokens = CRM_Utils_Token::getTokens($input);
    // get replacement text for these tokens
    $returnProperties = array(
      'sort_name' => 1,
      'email' => 1,
      'do_not_email' => 1,
      'is_deceased' => 1,
      'on_hold' => 1,
      'display_name' => 1,
      'preferred_mail_format' => 1,
    );
    if (isset($tokens['contact'])) {
      foreach ($tokens['contact'] as $key => $value) {
        $returnProperties[$value] = 1;
      }
    }
    list($details) = CRM_Utils_Token::getTokenDetails(array($contact_id), $returnProperties, false, false, null, $tokens);
    $contact = reset($details);

    // call token hook
    $hookTokens = array();
    CRM_Utils_Hook::tokens($hookTokens);
    $categories = array_keys($hookTokens);

    CRM_Utils_Token::replaceGreetingTokens($input, NULL, $contact['contact_id']);
    $input = CRM_Utils_Token::replaceDomainTokens($input, $domain, true, $tokens, true);
    $input = CRM_Utils_Token::replaceContactTokens($input, $contact, false, $tokens, false, true);
    $input = CRM_Utils_Token::replaceComponentTokens($input, $contact, $tokens, true);
    $input = CRM_Utils_Token::replaceHookTokens($input, $contact, $categories, true);

    return $input;
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