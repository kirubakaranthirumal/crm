<?php

$lang = array();

$lang['user_blocked'] = "You are currently locked out of the system.";

$lang['email_password_empty'] = "Email cannot not be blank.";
$lang['remail_password_empty'] = "Email cannot not be blank.";
$lang['password_cpassword_empty'] = "<li>Password cannot be blank.</li><li>Confirm password cannot be blank.</li>";
$lang['email_empty'] = "Email cannot be blank.";
$lang['name_empty'] = "Name cannot be blank.";
$lang['name_short'] = "Name must be atleast 3 characters";
$lang['password_empty'] = "Password cannot be blank.";
$lang['cpassword_empty'] = "Confirm password cannot be blank.";
$lang['email_invalid'] = "Email address incorrect.";
$lang['email_invalid'] = "Email address incorrect.";
$lang['password_invalid'] = "Password incorrect.";
$lang['remember_me_invalid'] = "The remember me field is invalid.";

$lang['password_short'] = "Password must be 6 characters in length.";
$lang['password_long'] = "Password is too long.";
$lang['password_wrong'] = "Password must be 6 characters in length.";
$lang['password_nomatch'] = "Confirm password must match.";
$lang['password_changed'] = "Password changed successfully.";
$lang['password_incorrect'] = "Password is incorrect.";
$lang['password_notvalid'] = "Password is invalid.";

$lang['newpassword_short'] = "New password is too short.";
$lang['newpassword_long'] = "New password is too long.";
$lang['newpassword_invalid'] = "Password must be 6 characters in length.";
$lang['newpassword_nomatch'] = "New passwords do not match.";
$lang['newpassword_match'] = "New password is the same as the old password.";

$lang['email_short'] = "Email address is too short.";
$lang['email_long'] = "Email address is too long.";
$lang['email_invalid'] = "Email address is invalid.";
$lang['email_incorrect'] = "Email address is incorrect.";
$lang['email_banned'] = "This email address is not allowed.";
$lang['email_changed'] = "Email address changed successfully.";

$lang['newemail_match'] = "New email matches previous email.";

$lang['account_inactive'] = "Account has not yet been activated. Please check your e-mail to activate.";
$lang['account_activated'] = "Account activated.";

$lang['logged_in'] = "You are now logged in.";
$lang['logged_out'] = "You are now logged out.";

$lang['system_error'] = "A system error has been encountered. Please try again.";

$lang['register_success'] = "Account created. Activation email sent to email.";
$lang['email_taken'] = "The email address is already in use.";
$lang['mobile_taken'] = "The phone number is already in use.";
$lang['email_not_taken'] = "User account does not exists";

$lang['resetkey_invalid'] = "Reset key is invalid.";
$lang['resetkey_incorrect'] = "Reset key is incorrect.";
$lang['resetkey_expired'] = "Reset key has expired.";
$lang['password_reset'] = "Password reset successfully.";

$lang['activationkey_invalid'] = "Activation key is invalid.";
$lang['activationkey_incorrect'] = "Activation key is incorrect.";
$lang['activationkey_expired'] = "Activation key has expired.";

$lang['reset_requested'] = "Password has been sent to your email address.";
$lang['reset_exists'] = "A reset request already exists.";

$lang['already_activated'] = "Account is already activated.";
$lang['activation_sent'] = "Activation email has been sent.";
$lang['activation_exists'] = "An activation email has already been sent.";

$lang['email_activation_subject'] = '%s - Activate account';
$lang['email_activation_body'] = 'Hello,<br/><br/> To be able to log in to your account you first need to activate your account by entering the following One Time Password. <br/><br/>Your OTP for IPTL is: <strong>%3$s</strong><br/><br/>If you did not request a otp on %1$s recently then this message was sent in error, please ignore it.';
$lang['email_activation_altbody'] = 'Hello, ' . "\n\n" . 'To be able to log in to your account you first need to activate your account by visiting the following link :' . "\n" . '%1$s/%2$s' . "\n\n" . 'You then need to use the following activation key: %3$s' . "\n\n" . 'If you did not sign up recently then this message was sent in error, please ignore it.';

$lang['email_invitation_subject'] = '%s - Chat Invitation';
$lang['email_invitation_body'] = 'Hello,<br/><br/> You have received an chat request from michale. <br/><br/>Click the below link to join the chat room: <strong>' . "\n" . '%1$s/%2$s&rid=%4$s&cid=%3$s' . "\n\n"  . '</strong><br/><br/>If you did not request a otp on %1$s recently then this message was sent in error, please ignore it.';
$lang['email_invitation_altbody'] = 'Hello,<br/><br/> You have received an chat request from michale. <br/><br/>Click the below link to join the chat room: <strong>' . "\n" . '%1$s/%2$s&rid=%4$s&cid=%3$s' . "\n\n"  . '</strong><br/><br/>If you did not request a otp on %1$s recently then this message was sent in error, please ignore it.';


$lang['email_reset_subject'] = '%s - Password Reset Link ';
$lang['email_reset_body'] = 'Hello,<br/><br/> To reset your password please visit the following link :,<br/><br/> ' . "\n" . '%1$s/%2$s' . "\n\n"  . ',<br/><br/> If you did not request a password reset key recently then this message was sent in error, please ignore it.';
$lang['email_reset_altbody'] = 'Hello,<br/><br/> To reset your password please visit the following link :,<br/><br/> ' . "\n" . '%1$s/%2$s' . "\n\n"  . ',<br/><br/> If you did not request a password reset key recently then this message was sent in error, please ignore it.';

$lang['account_deleted'] = "Account deleted successfully.";

?>
