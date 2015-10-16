<?php

/**
 * Collection of upgrade steps.
 */
class CRM_Civiruleshttppost_Upgrader extends CRM_Civiruleshttppost_Upgrader_Base {

  public function install() {
    $this->executeSqlFile('sql/twitter.sql');
  }

  public function uninstall() {
   CRM_Core_DAO::executeQuery("DROP TABLE `civirule_twitter_action`");
  }

  public function upgrade_1001() {
    $this->executeSqlFile('sql/twitter.sql');
    return TRUE;
  }
}
