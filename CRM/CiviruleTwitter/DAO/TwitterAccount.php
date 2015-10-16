<?php

class CRM_CiviruleTwitter_DAO_TwitterAccount extends CRM_Core_DAO {
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = null;
  static $_export = null;
  /**
   * empty definition for virtual function
   */
  static function getTableName() {
    return 'civirule_twitter_action';
  }
  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  static function &fields() {
    if (!(self::$_fields)) {
      self::$_fields = array(
        'id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'required' => true,
        ) ,
        'description' => array(
          'name' => 'description',
          'label' => ts('Description'),
          'type' => CRM_Utils_Type::T_STRING,
          'maxlength' => 128,
          'required' => true,
          'size' => CRM_Utils_Type::HUGE,
        ) ,
        'twitter_name' => array(
          'name' => 'twitter_name',
          'label' => ts('Twitter name'),
          'type' => CRM_Utils_Type::T_STRING,
          'maxlength' => 128,
          'required' => true,
          'size' => CRM_Utils_Type::HUGE,
        ),
        'consumer_key' => array(
          'name' => 'consumer_key',
          'label' => ts('Consumer key'),
          'type' => CRM_Utils_Type::T_STRING,
          'maxlength' => 128,
          'required' => true,
          'size' => CRM_Utils_Type::HUGE,
        ),
        'consumer_secret' => array(
          'name' => 'consumer_secret',
          'label' => ts('Consumer secret'),
          'type' => CRM_Utils_Type::T_STRING,
          'maxlength' => 128,
          'required' => true,
          'size' => CRM_Utils_Type::HUGE,
        ),
        'access_token' => array(
          'name' => 'access_token',
          'label' => ts('Access token'),
          'type' => CRM_Utils_Type::T_STRING,
          'maxlength' => 128,
          'required' => true,
          'size' => CRM_Utils_Type::HUGE,
        ),
        'access_secret' => array(
          'name' => 'access_secret',
          'label' => ts('Access secret'),
          'type' => CRM_Utils_Type::T_STRING,
          'maxlength' => 128,
          'required' => true,
          'size' => CRM_Utils_Type::HUGE,
        ),
      );
    }
    return self::$_fields;
  }
  /**
   * Returns an array containing, for each field, the array key used for that
   * field in self::$_fields.
   *
   * @access public
   * @return array
   */
  static function &fieldKeys() {
    if (!(self::$_fieldKeys)) {
      self::$_fieldKeys = array(
        'id' => 'id', 
        'description' => 'description',
        'twitter_name' => 'twitter_name',
        'consumer_key' => 'consumer_key',
        'consumer_secret' => 'consumer_secret',
        'access_token' => 'access_token',
        'access_secret' => 'access_secret',
      );
    }
    return self::$_fieldKeys;
  }
  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   * @static
   */
  static function &export($prefix = false)
  {
    if (!(self::$_export)) {
      self::$_export = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['civirule_twitter_action'] = & $fields[$name];
          } else {
            self::$_export[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}