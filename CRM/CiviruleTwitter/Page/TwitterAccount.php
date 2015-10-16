<?php

class CRM_CiviruleTwitter_Page_TwitterAccount extends CRM_Core_Page_Basic {

  /**
   * The action links that we need to display for the browse screen
   *
   * @var array
   * @static
   */
  static $_links = null;

  function getBAOName() {
    return 'CRM_CiviruleTwitter_BAO_TwitterAccount';
  }

  /**
   * Get action Links
   *
   * @return array (reference) of action links
   */
  function &links() {
    if (!(self::$_links)) {
      self::$_links = array(
        CRM_Core_Action::UPDATE  => array(
          'name'  => ts('Edit'),
          'url'   => 'civicrm/admin/twitter_account',
          'qs'    => 'action=update&id=%%id%%&reset=1',
          'title' => ts('Edit Financial Type'),
        ),
        CRM_Core_Action::DELETE  => array(
          'name'  => ts('Delete'),
          'url'   => 'civicrm/admin/twitter_account',
          'qs'    => 'action=delete&id=%%id%%',
          'title' => ts('Delete Financial Type'),
        ),
      );
    }
    return self::$_links;
  }

  /**
   * Get name of edit form
   *
   * @return string Classname of edit form.
   */
  function editForm() {
    return 'CRM_CiviruleTwitter_Form_TwitterAccount';
  }

  /**
   * Get edit form name
   *
   * @return string name of this page.
   */
  function editName() {
    return 'CRM_CiviruleTwitter_Form_TwitterAccount';
  }

  /**
   * Get user context.
   *
   * @return string user context.
   */
  function userContext($mode = null) {
    return 'civicrm/admin/twitter_account';
  }

}