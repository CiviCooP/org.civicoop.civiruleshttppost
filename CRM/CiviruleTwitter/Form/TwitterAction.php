<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_CiviruleTwitter_Form_TwitterAction extends CRM_CivirulesActions_Form_Form {
  function buildQuickForm() {
    $this->setFormTitle();

    $this->add('hidden', 'rule_action_id');
    $this->add('select', 'twitter_account', ts('Twitter account'), $this->getTwitterAccounts(), true);
    $this->add('textarea', 'status', ts('Status'));

    $this->addButtons(array(
      array('type' => 'next', 'name' => ts('Save'), 'isDefault' => TRUE,),
      array('type' => 'cancel', 'name' => ts('Cancel'))));

    parent::buildQuickForm();
  }

  /**
   * Overridden parent method to set default values
   *
   * @return array $defaultValues
   * @access public
   */
  public function setDefaultValues() {
    $defaultValues = parent::setDefaultValues();
    $data = unserialize($this->ruleAction->action_params);
    if (!empty($data['twitter_account'])) {
      $defaultValues['twitter_account'] = $data['twitter_account'];
    }
    if (!empty($data['status'])) {
      $defaultValues['status'] = $data['status'];
    }
    return $defaultValues;
  }

  protected function getSubmittedData() {
    $data = array();
    $data['twitter_account'] = $this->_submitValues['twitter_account'];
    $data['status'] = $this->_submitValues['status'];
    return $data;
  }

  function postProcess() {
    $data = $this->getSubmittedData();
    $this->ruleAction->action_params = serialize($data);
    $this->ruleAction->save();
    parent::postProcess();
  }

  function getTwitterAccounts() {
    $object = new CRM_CiviruleTwitter_BAO_TwitterAccount();
    $object->find();
    $return = array();
    while ($object->fetch()) {
      $return[$object->id] = '@'.$object->twitter_name.' - '.$object->description;
    }
    return $return;
  }
}
