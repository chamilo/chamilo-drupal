<?php
/* For licensing terms, see /license.txt */

/**
 * Class ChamiloConnector
 * This script receives user creation calls from a Chamilo portal
 *
 * @package drupal.sites.all.modules.chamilo.soap.php
 * @author  Imanol Losada <imanol.losada@beeznest.com>
 *
 * Drupal-Chamilo connector class
 */
class ChamiloConnector {

    /**
     * defineConstants (defines needed constants)
     */
    private function defineConstants() {
        define('DRUPAL_ROOT', dirname(__FILE__).'/../../../..');
    }

    /**
     * includeFiles (include needed files)
     */
    private function includeFiles() {
        $paths = array(
            '/includes/entity.inc',
            '/includes/database/database.inc',
            '/includes/bootstrap.inc',
            '/includes/cache.inc',
            '/includes/common.inc',
            '/includes/mail.inc',
            '/includes/module.inc',
            '/includes/path.inc',
            '/includes/session.inc',
            '/includes/token.inc',
            '/includes/unicode.inc',
            '/modules/field/field.module',
            '/modules/field/field.attach.inc',
            '/modules/filter/filter.module',
            '/modules/system/system.mail.inc',
            '/modules/user/user.module'
        );
        foreach ($paths as $path) {
            require_once DRUPAL_ROOT.$path;
        }
    }

    /**
     * setConnectionInfo (retrieves database connection info from settings.php and adds it)
     */
    private function setConnectionInfo() {
        require_once DRUPAL_ROOT.'/sites/default/settings.php';
        // $databases is taken straight from '/sites/default/settings.php'
        $key = array_shift(array_keys($databases));
        $target = array_shift(array_keys($databases[$key]));
        $info = $databases[$key][$target];
        Database::addConnectionInfo($key, $target, $info);
    }

    /**
     * getExistingUserExtraFields (returns existing user extra fields)
     * @param   array User extra fields
     * @return  array Existing user extra fields or an empty array
     */
    private function getExistingUserExtraFields($extraFields) {
        $existingExtraFields = array();
        foreach ($extraFields as $key => $value) {
            $extraField = $this->getExistingUserExtraField(array($key => $value));
            $existingExtraFields = array_merge($existingExtraFields, $extraField);
        }
        return $existingExtraFields;
    }

    /**
     * getExistingUserExtraField (returns an existing user extra field)
     * @param   array User extra field
     * @return  array Existing user extra field or an empty array
     */
    private function getExistingUserExtraField($extraField) {
        $key = array_shift(array_keys($extraField));
        return Database::getConnection()->schema()->fieldExists('users', $key) ? $extraField : array();
    }

    /**
     * addUser (adds the user to Drupal if its username is available)
     * @param   array User fields
     * @param   array User extra fields
     */
    public function addUser($fields, $extraFields = null) {
        $this->defineConstants();
        $this->includeFiles();
        $this->setConnectionInfo();
        // Save the user only if the username is available in Drupal
        if (!user_load_by_name($fields['name'])) {
            if (!is_null($extraFields)) {
                $extraFields = $this->getExistingUserExtraFields($extraFields);
                $fields = array_merge($fields, $extraFields);
            }
            user_save(new StdClass(), $fields);
        }
    }

    /**
     * activateUser (activates or deactivates an existing user in Drupal)
     * @param   string  User name
     * @param   string  User status
     */
    public function activateUser($username, $status) {
        $this->defineConstants();
        $this->includeFiles();
        $this->setConnectionInfo();
        // Modify the user only if the username exists in Drupal
        if ($user = user_load_by_name($username)) {
            $user->status = $status;
            user_save($user);
        }
    }

    /**
     * getProfileCompletionPercentage (returns the completion percentage of a
     * profile from a given drupal user id)
     * @param   string      Drupal user id
     * @return  int|float   Profile completion percentage
     */
    public function getProfileCompletionPercentage($drupalUserId) {
        $this->defineConstants();
        $this->includeFiles();
        $this->setConnectionInfo();
        require_once DRUPAL_ROOT.'/sites/all/modules/chamilo/chamilo_course_detail_ajax.inc';
        return chamilo_percentage_full_user_profile($drupalUserId);
    }
}

$server = new SoapServer(null, array('uri'=>'http://localhost/'));
$server->setClass('ChamiloConnector');
$server->handle();
