
Chamilo-Drupal module
====================
This module provides connectivity between a Drupal website and a Chamilo LMS.
Although stable, this module still lacks a good pack of usability features, so
please try it on a test server before you put it online.
This vesion is intended to work in combination with Chamilo 1.8.8, which
includes a series of improvements that cuts down the efforts of installation.

Its current features are
- Single Sign On from Drupal to Chamilo
- View list of Chamilo courses in a Drupal block
- View list of own Chamilo courses in a Drupal block
- View list of own Chamilo events in a Drupal block

To enable the Single Sign On, you should:
- install the soapclient module (http://drupal.org/project/soapclient)
- always use HTTPS (because otherwise your call to Chamilo is not secure)
- use the same hashing/encryption method in Drupal and Chamilo. If you used the
standard MD5 hashing method in Drupal, make sure you pick "MD5" during the
Chamilo installation process. Otherwise, passwords will not be matched and you
will always get sent back to Drupal
- login on your Chamilo portal and configure the SSO module from the Security 
tab in your admin section (only enable SSO and and define the SSO master domain,
which should be the url of your Drupal portal - see help above the field)

Once configured on the Chamilo side, make sure you:
- configure the Chamilo module in the Drupal interface
-- the Security Key there is *not* the admin password, it is the security_key variable you can find in your Chamilo's main/inc/conf/configuration.php file
- configure the visibility of courses you want to get from Chamilo
- make some blocks visible in your blocks section
- give users permission to define their Chamilo settings (each user not created in Chamilo *through Drupal* will have to configure his Chamilo username inside his Drupal profile page)

This should work (it requires accounts on Drupal to be created with the same
username and password as in Chamilo).
