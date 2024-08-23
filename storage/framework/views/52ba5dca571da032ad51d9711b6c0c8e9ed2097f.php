<!DOCTYPE html>
<html>
<?php echo $__env->make('frontend.include.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="body">
    <div class="loader-bg d-none">
        <section><span class="loader-11"> </span></section>
    </div>
    <!--------------------------
 HEADER START
 --------------------------->
    <?php if(Auth::check()): ?>
        <?php if(Auth::user()->role_id == '3'): ?>
            <?php echo $__env->make('frontend.include.header-company-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('frontend.include.header-after-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php echo $__env->make('frontend.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <!--------------------------
 HEADER END
 --------------------------->

    <div class="ajax-alert">

    </div>


    <!--------------------------
 CONTENT START
 --------------------------->
    <?php echo $__env->yieldContent('content'); ?>
    <!--------------------------
 CONTENT END
 --------------------------->

    <!--------------------------
 FOOTER START
 --------------------------->
    <?php echo $__env->make('frontend.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--------------------------
 FOOTER END
 --------------------------->
    <?php echo $__env->make('frontend.include.copy-right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
<?php echo $__env->make('frontend.include.bottom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(Session::has('message')): ?>
    <script>
        var type = "<?php echo e(Session::get('alert-type', 'info')); ?>";
        switch (type) {
            case 'info':
                toastr.info("<?php echo e(Session::get('message')); ?>");
                break;

            case 'warning':
                toastr.warning("<?php echo e(Session::get('message')); ?>");
                break;

            case 'success':
                toastr.success("<?php echo e(Session::get('message')); ?>");
                break;

            case 'error':
                toastr.error("<?php echo e(Session::get('message')); ?>");
                break;
        }
    </script>
<?php endif; ?>
<script>
    $("#bookRequestFromPopup").validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
            },
            email: {
                required: true,
                regex: /\S+@\S+\.\S+/,
            },
            phone: {
                required: true,
                number: true,
            },
            requirement: {
                required: true,
            },
        },

        submitHandler: function(form) {
            $('.loader-bg').removeClass('d-none');
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.statusCode == '200') {
                        $('.loader-bg').addClass('d-none');
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.error(response.message);
                        $("#bookADemo .close").click();
                        document.getElementById('bookRequestFromPopup').reset();
                    } else {
                        $('.loader-bg').addClass('d-none');
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.error(response.component.error);
                    }
                }
            });
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element);
            }

        },
    });

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please enter a valid email address."
    );
</script>

</html>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/layouts/master.blade.php ENDPATH**/ ?>