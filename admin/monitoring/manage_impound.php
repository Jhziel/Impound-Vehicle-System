<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `impound_vehicle_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<style>
    .uploaded_img {
        width: 150px;
        height: 135px;
        object-fit: scale-down;
        object-position: center center;
    }

    .img-panel {
        width: 170px;
    }
</style>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Monitoring</h3>
    </div>
    <div class="card-body">
        <form action="" id="offense-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">


            <div class="col-6 ">
                <div class="form-group">
                    <label for="" class="control-label">Release Photo</label>
                    <div class="custom-file">
                        <input type="hidden" name="image_path" value="<?php echo isset($image_path) ? $image_path : '' ?>">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <img align="center" src="<?php echo validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>

            </div>




    </div>
    <hr>


    </form>
</div>
<div class="card-footer">
    <button class="btn btn-flat btn-primary" form="offense-form">Save</button>
    <a class="btn btn-flat btn-default" href="?page=offenses">Cancel</a>
</div>
</div>
<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
                _this.siblings('.custom-file-label').html(input.files[0].name)
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {


        $('#offense-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=release_photo",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {

                    } else {
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })

    })
</script>