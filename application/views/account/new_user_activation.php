Dear <?php echo $user["firstname"]; ?> <?php echo $user["lastname"]; ?>,

We have received your account registration request at:

http://casimira.com.hk

Please review your registration details:

client name: <?php echo $user["firstname"]; ?> <?php echo $user["lastname"]; ?>

email: <?php echo $user["email"]; ?>

password: <?php echo $user["raw_password"]; ?>

You can now activate your account via the following link:

<?php echo site_url(); ?>register/activate/<?php echo rawurlencode($user["email"]); ?>/<?php echo $user["activate_code"]; ?>/


For any other inquiries please contact:
info@casimira.com.hk

Best regards,
Casimira