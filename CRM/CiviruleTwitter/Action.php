<?php

class CRM_CiviruleTwitter_Action extends CRM_Civiruleshttppost_HttpPostAction {

  protected function alterHttpRequestObject(\Httpful\Request $request, CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $request = parent::alterHttpRequestObject($request, $triggerData);

    $request->expectsJson();
    $request->addHeader('Authorization', $this->buildOauthHeader($triggerData));

    return $request;
  }

  protected function buildOauthHeader(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $params = $this->getActionParameters();
    $twitter_account = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    $twitter_account->id = $params['twitter_account'];
    if (!$twitter_account->find(true)) {
      throw new Exception('Could not find twitter account with id: '.$params['twitter_account']);
    }

    $options = array( 'consumer_key' => $twitter_account->consumer_key, 'consumer_secret' => $twitter_account->consumer_secret );
    OAuthStore::instance("2Leg", $options );

    $secrets['timestamp'] = time();
    $secrets['nonce'] = mt_rand();
    $secrets['consumer_key'] = $twitter_account->consumer_key;
    $secrets['consumer_secret'] = $twitter_account->consumer_secret;
    $secrets['token'] = $twitter_account->access_token;
    $secrets['token_secret'] = $twitter_account->access_secret;
    $secrets['signature_methods'] = array('HMAC-SHA1');

    $oauth = new OAuthRequestSigner($this->replaceUriTokens($triggerData), $this->getHttpMethod(), array(), $this->replaceRequestBodyTokens($triggerData));
    $oauth->sign(0, $secrets);
    $header = $oauth->getAuthorizationHeader();
    return str_replace("Authorization: ", "", $header);
  }

  protected function getRequestBody() {
    $params = $this->getActionParameters();
    return $params['status'];
  }

  protected function getUri() {
    return 'https://api.twitter.com/1.1/statuses/update.json';
  }

  protected function getHttpMethod() {
    return 'POST';
  }

  protected function replaceUriTokens(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    return $this->getUri();
  }

  protected function replaceRequestBodyTokens(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $status = $this->replaceTokens($this->getRequestBody(), $triggerData->getContactId());
    return 'status='.urlencode($status);
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
    return CRM_Utils_System::url('civicrm/civirules/action/form/twitter_action', 'rule_action_id='.$ruleActionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    $params = $this->getActionParameters();
    $account = ts('Unknown');
    $twitter_account = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    $twitter_account->id = $params['twitter_account'];
    if ($twitter_account->find(true)) {
      $account = '@'.$twitter_account->twitter_name.' - '.$twitter_account->description;
    }
    return sprintf('Tweet: "%s" at "%s"', $params['status'], $account);
  }

}