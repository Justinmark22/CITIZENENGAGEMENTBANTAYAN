<?php $__env->startComponent('mail::message'); ?>
# New Contact Message

**Name:** <?php echo e($data['name']); ?>  
**Email:** <?php echo e($data['email']); ?>  
**Phone:** <?php echo e($data['phone'] ?? 'N/A'); ?>  
**Subject:** <?php echo e($data['subject'] ?? 'N/A'); ?>


**Message:**  
<?php echo e($data['message']); ?>


<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\ADMIN\my-app\CITIZENENGAGEMENTBANTAYAN\resources\views/emails/contact.blade.php ENDPATH**/ ?>