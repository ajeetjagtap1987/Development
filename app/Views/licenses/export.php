<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <?php echo @view('includes/breadcrumb2', ['level_1' => 'License List', 'level_1_url' => 'licenses/list', 'level_2' => 'license Export']); ?>
    </div>
    <script>

    </script>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <?php
                    if (session()->has("error")) {
                    ?>
                        <div class="alert alert-danger alert-dismissible">
                            <?php echo session("error"); ?>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if (session()->has("success")) {
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <?php echo session("success"); ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="card">
                        <div class="card-body">

                            <!-- <a href="http://localhost/git_projects/it_inventory/users/details/f3ec216521cb68dbb1219867b35bbbda5fe57027b48eb62ed4d33c843b460f2620b5acd32ae538d0b167c3c1c3dd59cf3d" class="btn btn-icon btn-md btn-info p-1" title="Assign">Export All<i class="ti ti-download"></i></a>
						<br><br> -->
                            <form action="<?php echo base_url(); ?>/licenses/export-data" method="post" autocomplete="off">
                                <?= csrf_field();  ?>


                                <div class="row">


                                    <div class="form-group col-md-6 mb-3 ">
                                        <label class="form-label ">License Name</label>
                                        <div>
                                            <select type="text" class="form-control" name="license_name[]"  id="license"  multiple="" multiple multiselect-search="true" multiselect-select-all="true">

                                                <?php
                                                if (count($license) > 0) {
                                                    foreach ($license as $l_name) {
                                                        echo '<option value="' . $l_name['id'] . '">' . $l_name['name'] . '</option>';
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6 mb-3">
                                        <label class="form-label ">Manufacture</label>
                                        <select type="text" class="form-control" name="manufacturer_id[]"   multiple="" multiple multiselect-search="true" multiselect-select-all="true">

                                            <?php
                                            if (count($manufacturer) > 0) {
                                                foreach ($manufacturer as $mf) {
                                                    echo '<option value="' . $mf['id'] . '">' . $mf['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>


                                </div>


                                <div class="row">


                                    <div class="form-group col-md-6 mb-3">
                                        <label class="form-label ">License Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">Expired</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6 mb-3">
                                        <label class="form-label ">Renewal</label>
                                        <select name="renewal[]" class="form-control" multiple="" multiple multiselect-search="true" multiselect-select-all="true">
                                            <option value="Yearly">Yearly</option>
                                            <option value="Half-yearly">Half-yearly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Monthly">Monthly</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
                                    <button class="btn btn-primary loader_button" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    // $(document).ready(function() {
    //     $("#type_role").on('change', function() {
    //         $(this).find("option:selected").each(function() {
    //             var type = $(this).attr("value");
    //             if (type == 6 || type == 7) {
    //                 $(".sqa").show();
    //             } else {
    //                 $(".sqa").hide();
    //             }

    //         });
    //     }).change();
    // });


    function selectAll() {
        alert("dfdf");
        die;
        options = document.getElementsByTagName("option");
        for (i = 0; i < options.length; i++) {
            options[i].selected = "true";
        }
    }
    $(document).ready(function() {


        $('#joining_date').datepicker({
            format: 'dd-mm-yyyy',

            autoclose: true
        });

        $("#insert").validate({

            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                job_title: {
                    required: true
                },

                reporting_head: {
                    required: true
                },

                joining_date: {
                    required: true,

                },
                user_type: {
                    required: true
                },
                department: {
                    required: true
                },

            },
            messages: {
                first_name: {
                    required: "Please enter your first name."
                },
                last_name: {
                    required: "Please enter your last name."
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                job_title: {
                    required: "Please enter your job title."
                },
                reporting_head: {
                    required: "Please select a reporting head."
                },

                joining_date: {
                    required: "Please select a joining date.",

                },
                user_type: {
                    required: "Please select a user type."
                },
                department: {
                    required: "Please select a department."
                },

            },
            submitHandler: function(form) {

                var post_url = $(form).attr("action");
                var request_method = $(form).attr("method");
                var form_data = new FormData(form);
                $('.submit_button').css('display', 'none');
                $('.loader_button').css('display', 'block');
                $.ajax({
                    url: post_url,
                    type: request_method,
                    data: form_data,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    statusCode: {
                        403: function() {
                            // Handle 403 error (CSRF token verification failed)
                            Swal.fire({
                                icon: 'error',
                                text: 'CSRF token verification failed',
                            });
                            window.location.href = '<?php echo base_url() ?>/users/list/';
                        }
                    },
                }).done(function(response) {
                    if (response.status == 'success') {
                        // Swal.fire({
                        //   icon: response.status,
                        //   text: response.message,
                        // });
                        window.location.href = '<?php echo base_url() ?>/users/list';
                    } else {
                        Swal.fire({
                            icon: response.status,
                            text: response.message,
                        })
                    }
                    $('.submit_button').css('display', 'block');
                    $('.loader_button').css('display', 'none');

                });

            }


        });
    });


    // 	function submit_data(){


    // 	$("#insert").submit(function(event) {
    // 		event.preventDefault();


    // 	});
    // }

    $(document).ready(function() {



        $(".microsoft_365_business_licence").change(function() {
            var microsoft_365_business_licence = $('.microsoft_365_business_licence').val();
            $('.microsoft_365_apps_for_business_div').hide();
            $('.microsoft_365_apps_for_business_input').prop("required", false);

            if (microsoft_365_business_licence == 'Microsoft 365 Business Basic') {
                $('.microsoft_365_apps_for_business_div').show();
                $('.microsoft_365_apps_for_business_input').prop("required", true);
            } else {
                $('.microsoft_365_apps_for_business_div').hide();
                $('.microsoft_365_apps_for_business_input').prop("required", false);
            }
        });
    });
</script>