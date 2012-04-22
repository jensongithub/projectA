Dear <?php echo $user["firstname"]; ?> <?php echo $user["lastname"]; ?>,

We have received your forgotten request at:

http://casimira.com.hk

Please click the link below to reset the password

<?php echo site_url(); ?>account/reset_password/<?php echo rawurlencode($user["email"]); ?>/<?php echo $user["activate_code"]; ?>/


For any other inquiries please contact:
info@casimira.com.hk

Best regards,
Casimira