<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- FOOTER ------------------------------------------------------------------------- -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <p class="f-info">Copyright: Torchuk M.V. 2016-2017</p>
            </div>
        </div>
    </div>
</footer>


<!-- JQUERY -->
<script src="<?php echo base_url()?>resources/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>

<!-- BOOTSTRAP javascript -->
<script src="<?php echo base_url()?>resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!-- MY javascript -->
<?php
if (isset($js_file))
    if ($js_file != '')
        echo "<script src='", base_url(), "resources/js/", $js_file, "' type='text/javascript'></script>";
?>
</body>
</html>
