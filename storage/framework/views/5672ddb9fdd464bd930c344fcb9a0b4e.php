<?php $__env->startComponent('mail::message'); ?>
# Welcome to Bantayan 911 🚨

Hi **<?php echo e($name); ?>**,  
Thank you for registering to **Bantayan 911** — your trusted emergency and community response system.

---

### 🔔 What's Next?
You can now:
- Report emergencies instantly  
- Stay updated with announcements  
- Connect directly with responders  

---

<?php $__env->startComponent('mail::button', ['url' => 'https://bantayan-911.com']); ?>
Go to Dashboard
<?php echo $__env->renderComponent(); ?>

Stay safe,  
**The Bantayan 911 Team**

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\ADMIN\my-app\CITIZENENGAGEMENTBANTAYAN\resources\views/emails/welcome_new_user.blade.php ENDPATH**/ ?>