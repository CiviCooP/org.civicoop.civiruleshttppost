<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Civiruleshttppost_Form_HttpPostAction extends CRM_CivirulesActions_Form_Form {
  function buildQuickForm() {
    $this->setFormTitle();

    $this->add('hidden', 'rule_action_id');
    $this->add('select', 'http_method', ts('URI'), $this->getHttpMethods(), true);
    $this->add('text', 'uri', ts('URI'), true);
    $this->add('textarea', 'request_body', ts('Request Body'));

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
    if (!empty($data['http_method'])) {
      $defaultValues['http_method'] = $data['http_method'];
    }
    if (!empty($data['uri'])) {
      $defaultValues['uri'] = $data['uri'];
    }
    if (!empty($data['request_body'])) {
      $defaultValues['request_body'] = $data['request_body'];
    }
    return $defaultValues;
  }

  protected function getSubmittedData() {
    $data = array();
    $data['http_method'] = $this->_submitValues['http_method'];
    $data['uri'] = $this->_submitValues['uri'];
    $data['request_body'] = $this->_submitValues['request_body'];
    return $data;
  }

  function postProcess() {
    $data = $this->getSubmittedData();
    $this->ruleAction->action_params = serialize($data);
    $this->ruleAction->save();
    parent::postProcess();
  }

  function getHttpMethods() {
    return array(
      'GET' => 'GET',
      'POST' => 'POST',
      'PUT' => 'PUT',
      'DELETE' => 'DELETE',
      'HEAD' =>  'HEAD',
      'PATCH' => 'PATCH',
      'OPTIONS' => 'OPTIONS',
    );
  }
}
