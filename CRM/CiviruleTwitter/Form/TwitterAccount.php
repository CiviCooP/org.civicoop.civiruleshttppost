<?php

class CRM_CiviruleTwitter_Form_TwitterAccount extends CRM_Core_Form {

  protected $_id;

  function preProcess() {
    $this->_id = $this->get('id');
  }

  public function buildQuickForm() {
    $this->_id = CRM_Utils_Request::retrieve('id' , 'Positive', $this);
    if ($this->_id) {
      $this->_title = CRM_Core_DAO::getFieldValue('CRM_CiviruleTwitter_BAO_TwitterAccount', $this->_id, 'twitter_name');
      CRM_Utils_System::setTitle($this->_title . ' - ' . ts( 'Twitter account'));
    }
    if ($this->_action & CRM_Core_Action::DELETE) {
      $this->addButtons(array(
          array(
            'type' => 'next',
            'name' => ts('Delete'),
            'isDefault' => TRUE,
          ),
          array(
            'type' => 'cancel',
            'name' => ts('Cancel'),
          ),
        )
      );
      return;
    }

    $this->add('text', 'twitter_name', ts('Name'), CRM_Core_DAO::getAttribute('CRM_CiviruleTwitter_BAO_TwitterAccount', 'twitter_name'), TRUE);
    $this->add('text', 'description', ts('Description'), CRM_Core_DAO::getAttribute('CRM_CiviruleTwitter_BAO_TwitterAccount', 'description'));

    $this->add('text', 'consumer_key', ts('Consumer key'), CRM_Core_DAO::getAttribute('CRM_CiviruleTwitter_BAO_TwitterAccount', 'consumer_key'), TRUE);
    $this->add('text', 'consumer_secret', ts('Consumer secret'), CRM_Core_DAO::getAttribute('CRM_CiviruleTwitter_BAO_TwitterAccount', 'consumer_secret'), TRUE);
    $this->add('text', 'access_token', ts('Access token'), CRM_Core_DAO::getAttribute('CRM_CiviruleTwitter_BAO_TwitterAccount', 'access_token'), TRUE);
    $this->add('text', 'access_secret', ts('Access secret'), CRM_Core_DAO::getAttribute('CRM_CiviruleTwitter_BAO_TwitterAccount', 'access_secret'), TRUE);

    if ($this->_action == CRM_Core_Action::UPDATE) {
      $this->assign('aid', $this->_id);
    }

    $this->addButtons(array(
        array(
          'type' => 'next',
          'name' => ts('Save'),
          'isDefault' => TRUE,
        ),
        array(
          'type' => 'cancel',
          'name' => ts('Cancel'),
        ),
      )
    );
  }

  public function setDefaultValues() {
    $defaults = array();
    $params = array();

    if (isset($this->_id)) {
      $params = array('id' => $this->_id);
      CRM_CiviruleTwitter_BAO_TwitterAccount::retrieve($params, $defaults);
    }
    return $defaults;
  }

  public function postProcess() {
    if ($this->_action & CRM_Core_Action::DELETE) {
      CRM_CiviruleTwitter_BAO_TwitterAccount::deleteWithId($this->_id);
      CRM_Core_Session::setStatus(ts('Selected twitter account has been deleted.'), '', 'success');
    } else {
      $params = array( );
      // store the submitted values in an array
      $params = $this->exportValues();
      if ($this->_action & CRM_Core_Action::UPDATE) {
        $params['id'] = $this->_id;
      }
      CRM_CiviruleTwitter_BAO_TwitterAccount::add($params);
      CRM_Core_Session::setStatus(ts('Your twitter account has been saved'),'', 'success');
    }
  }

}