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
            '/includes/lock.inc',
            '/includes/mail.inc',
            '/includes/path.inc',
            '/includes/session.inc',
            '/includes/token.inc',
            '/includes/unicode.inc',
            '/includes/module.inc',
            '/modules/field/field.module',
            '/modules/field/modules/field_sql_storage/field_sql_storage.module',
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
        return Database::getConnection()->schema()->fieldExists('users', $extraField) ? $extraField : array();
    }

    /**
     * @param array $extraFields
     * @return array
     */
    private function getExistingUserExtraFieldInTable($extraFields)
    {
        $resultExtraFields = array();
        foreach ($extraFields as $extraField => $value) {
            // If field does not exists in the user table check the "extra fields" tables
            if (!$this->getExistingUserExtraField($extraField)) {
                $tableName = 'field_data_field_' . $extraField;
                $tableExists = Database::getConnection()->schema()->tableExists($tableName);
                if ($tableExists) {
                    $exists = Database::getConnection()->schema()->fieldExists($tableName, 'field_'.$extraField . '_value') ? $extraField : array();
                    if ($exists) {
                        $resultExtraFields['field_'.$extraField]['und'][]['value'] = $value;
                    }
                }
            }
        }

        return $resultExtraFields;
    }

    /**
     * addUser (adds the user to Drupal if its username is available)
     * @param   array       User fields
     * @param   array       User extra fields
     * @return  int|bool    User id. Returns false if failed
     */
    public function addUser($fields, $extraFields = null)
    {
        $this->defineConstants();
        $this->includeFiles();
        $language = array(
            'language' => 'es',
            'name' => 'Spanish',
            'native' => 'Espa\xc3\xb1ol',
            'direction' => '0',
            'enabled' => '1',
            'plurals' =>'2',
            'formula' => '($n!=1)',
            'domain' => '',
            'prefix' => 'es',
            'weight' => '0',
            'javascript' => 'Keveksn1_L09RyfFu1bShDd32KpGOTS4DyCt8ulpEcY',
            'provider' => 'language-default'
        );
        $GLOBALS['language'] = (object)$language;

        $this->setConnectionInfo();
        $uid = false;
        // Save the user only if the username is available in Drupal
        if (!user_load_by_name($fields['name'])) {
            if (!is_null($extraFields)) {
                //$extraFields = $this->getExistingUserExtraFields($extraFields);
                $extraFields = $this->getExistingUserExtraFieldInTable($extraFields);
                $fields = array_merge($fields, $extraFields);
            }

            $user = user_save(new StdClass(), $fields);
            $uid = $user->uid;
        }
        return $uid;
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

    /**
     * Get the created user id
     * @param string $name The user name
     * @return int User id
     */
    public function getUserId($name)
    {
        $this->defineConstants();
        $this->includeFiles();
        $this->setConnectionInfo();

        $user = user_load(array('name' => check_plain($name)));

        if ($user === false || count($user) === 0) {
            return false;
        }

        return $user->uid;
    }

}

$server = new SoapServer(null, array('uri'=>'http://localhost/'));
$server->setClass('ChamiloConnector');
$server->handle();
