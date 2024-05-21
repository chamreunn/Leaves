<meta charset="utf-8" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

<title><?php echo $pageTitle ?></title>

<meta name="description"
    content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
<meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5" />
<!-- Canonical SEO -->
<link rel="canonical" href="../search-horizontal.json" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
<script>
(function(w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
})(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
</script>
<!-- End Google Tag Manager -->

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
<link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
<link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../../assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
<!-- Page CSS -->
<link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css">
<link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css">
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css">
<link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css">
<link rel="stylesheet" href="../../assets/vendor/libs/tagify/tagify.css">
<link rel="stylesheet" href="../../assets/vendor/libs/toastr/toastr.css">
<link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css">
<link rel="stylesheet" href="../../assets/vendor/libs/spinkit/spinkit.css">
<!-- Helpers -->
<link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/animate-css/animate.css">
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css">
<!-- Page CSS -->
<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
<!-- Page -->
<link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />
<!-- full edit textarea css  -->
<link rel="stylesheet" href="../../assets/vendor/libs/quill/editor.css">
<link rel="stylesheet" href="../../assets/vendor/libs/quill/katex.css">
<link rel="stylesheet" href="../../assets/vendor/libs/quill/typography.css">
<!-- end full edit textarea css  -->
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs/datatables.bootstrap5.css">
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<!-- Helpers -->
<script src="../../assets/vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="../../assets/vendor/js/template-customizer.js"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="../../assets/js/config.js"></script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()
</script>