<?php

class CRM_CiviruleTwitter_BAO_TwitterAccount extends CRM_CiviruleTwitter_DAO_TwitterAccount {

  /**
   * Function to get values
   *
   * @return array $result found rows with data
   * @access public
   * @static
   */
  public static function getValues($params) {
    $result = array();
    $account = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    if (!empty($params)) {
      $fields = self::fields();
      foreach ($params as $key => $value) {
        if (isset($fields[$key])) {
          $account->$key = $value;
        }
      }
    }
    $account->find();
    while ($account->fetch()) {
      $row = array();
      self::storeValues($account, $row);
      $result[$row['id']] = $row;
    }
    return $result;
  }

  /**
   * Takes a bunch of params that are needed to match certain criteria and
   * retrieves the relevant objects. Typically the valid params are only
   * contact_id. We'll tweak this function to be more full featured over a period
   * of time. This is the inverse function of create. It also stores all the retrieved
   * values in the default array
   *
   * @param array $params   (reference ) an assoc array of name/value pairs
   * @param array $defaults (reference ) an assoc array to hold the flattened values
   * @return CRM_CiviruleTwitter_BAO_TwitterAccount
   *
   * @access public
   * @static
   */
  static function retrieve( &$params, &$defaults ) {
    $twitterAccount = new CRM_CiviruleTwitter_BAO_TwitterAccount( );
    $twitterAccount->copyValues( $params );
    if ($twitterAccount->find(true)) {
      CRM_Core_DAO::storeValues( $twitterAccount, $defaults );
      return $twitterAccount;
    }
    return null;
  }

  public static function add($params) {
    $result = array();
    if (empty($params)) {
      throw new Exception('Params can not be empty when adding or updating a twitter account');
    }

    if (!empty($params['id'])) {
      CRM_Utils_Hook::pre('edit', 'TwitterAccount', $params['id'], $params);
    }
    else {
      CRM_Utils_Hook::pre('create', 'TwitterAccount', NULL, $params);
    }

    $account = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    $fields = self::fields();
    foreach ($params as $key => $value) {
      if (isset($fields[$key])) {
        $account->$key = $value;
      }
    }
    $account->save();
    self::storeValues($account, $result);

    if (!empty($params['id'])) {
      CRM_Utils_Hook::post('edit', 'TwitterAccount', $account->id, $account);
    }
    else {
      CRM_Utils_Hook::post('create', 'TwitterAccount', $account->id, $account);
    }

    return $result;
  }

  /**
   * Function to delete with id
   *
   * @param int $id
   * @throws Exception when id is empty
   * @access public
   * @static
   */
  public static function deleteWithId($id) {
    if (empty($id)) {
      throw new Exception('id can not be empty when attempting to delete a twitter account');
    }

    CRM_Utils_Hook::pre('delete', 'TwitterAccount', $id, CRM_Core_DAO::$_nullArray);

    $rule = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    $rule->id = $id;
    $rule->delete();

    CRM_Utils_Hook::post('delete', 'TwitterAccount', $id, CRM_Core_DAO::$_nullArray);

    return;
  }
}