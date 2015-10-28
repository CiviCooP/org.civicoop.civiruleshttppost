<?php

class CRM_CiviruleTwitter_Action extends CRM_Civiruleshttppost_HttpPostAction {

  protected function alterHttpRequestObject(\Httpful\Request $request, CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $request = parent::alterHttpRequestObject($request, $triggerData);

    $request->contentType('application/x-www-form-urlencoded');

    $params = $this->getActionParameters();
    $twitter_account = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    $twitter_account->id = $params['twitter_account'];
    if (!$twitter_account->find(true)) {
      throw new Exception('Could not find twitter account with id: '.$params['twitter_account']);
    }

    $oauth = new CRM_Civiruleshttppost_Oauth($twitter_account->consumer_key, $twitter_account->consumer_secret, $twitter_account->access_token, $twitter_account->access_secret);
    $request = $oauth->signRequest($request);
    return $request;
  }

  protected function getFullUri(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    return 'https://api.twitter.com/1.1/statuses/update.json';
  }

  protected function getBodyParams(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $bodyParams = parent::getBodyParams($triggerData);
    $params = $this->getActionParameters();
    $bodyParams['status'] = trim($this->replaceTokens($params['status'], $triggerData->getContactId())).' '.time();
    return $bodyParams;
  }

  protected function getHttpMethod() {
    return 'POST';
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
      $description = '';
      if ($twitter_account->description) {
        $description = ' "'.$twitter_account->description.'"';
      }
      $account = '@'.$twitter_account->twitter_name.' '.$description;
    }
    return sprintf('Tweet: "%s" %s', $params['status'], $account);
  }

}