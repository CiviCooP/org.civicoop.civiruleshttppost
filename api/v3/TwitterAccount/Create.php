<?php
/**
 * CiviRuleRule.Create API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_twitter_account_create_spec(&$spec) {
  $spec['id']['api_required'] = 0;
  $spec['description']['api_required'] = 1;
  $spec['twitter_name']['api_required'] = 1;
}

/**
 * CiviRuleRule.Create API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 *
 *
 */
function civicrm_api3_civi_rule_rule_create($params) {
  if (empty($params['twitter_name'])) {
    return civicrm_api3_create_error('Twitter_name can not be empty');
  }
  if (empty($params['description'])) {
    return civicrm_api3_create_error('Description can not be empty');
  }

  $returnValues = CRM_Civirules_BAO_Rule::add($params);
  return civicrm_api3_create_success($returnValues, $params, 'CiviRuleRule', 'Create');
}

