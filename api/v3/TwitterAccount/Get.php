<?php

function civicrm_api3_twitter_account_get($params) {
  $returnValues = CRM_CiviruleTwitter_BAO_TwitterAccount::getValues($params);
  return civicrm_api3_create_success($returnValues, $params, 'TwitterAccount', 'Get');
}