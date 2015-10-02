<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="span12">
                <div class="span2"></div>
                <div class="span8">
                    <div class="row-fluid">
                        <?php echo $this->session->flashdata('info'); ?> 
                        <form class="basic-detail"  method="post" action="http://webdekeyif.com/index.php/user/updateUser" novalidate="novalidate">
                            <div class="span12"> <fieldset><h3>User Profile</h3></fieldset></div>
                            <div class="span12">
                                <?php 
//                                echo '<pre>';
//                                print_r($this->session->all_userdata());
//                                echo '</pre>';
                                ?>
                                <label class="span3">First Name</label>
                                <input type="text" required="" name="first_name" value="<?php echo $user_data->getfirstname(); ?>"  class="span9" />
                            </div>
                            <div class="span12"> 
                                <label class="span3">Last Name</label>
                                <input type="text" required="" name="last_name" value="<?php print $user_data->getlastname(); ?>"  class="span9" />
                            </div>

                            <div class="span12">
                                <label class="span3">Email</label>
                                <input type="email" required=""  name="email" value="<?php echo $user_data->getemail(); ?>" class="span9">
                            </div>

                            <div class="span12">
                                <label class="span3">Date of Birth</label>
                                <input type="text" required="" name="dob" value="<?php echo $user_data->getdob(); ?>" class="span9">
                            </div>

                            <div class="span12">
                                <label class="span3">Mobile</label>
                                <input type="number" required="" id="user_moblie" name="phone" value="<?php echo $user_data->getphone(); ?>" class="span9">
                            </div>

                            <div class="span12">
                                <label class="span3">Registered On</label>
                                <input type="text" readonly="" id="register_on" value="<?php echo $user_data->getregisteron(); ?>"  name="user_registered" class="span9">
                            </div>
                                <div class="span12">
                                    <label class="span3">Upload File</label>
                                    <div id="profilePic">
                                        <img id="img_prev" src="#" alt="" />
                                    </div>
                                    <div class="span9 user_update_profile">
                                        <div class="" id="fileuploader">Upload</div>
                                    </div>
                                </div>
                                <script>
                                $(document).ready(function()
                                {
                                    $("#fileuploader").uploadFile({
                                        url: "<?php echo site_url('user/upload_user_pic'); ?>/myfile",
                                        fileName: "myfile"
                                    });
                                });</script>



                    <!--<a href="<?php //echo base_url();               ?>index.php/blogger/step_two" class="btn btn-primary pull-right next">Next</a>-->
                                <div class="span12 mr_btm_10">
                                    <div class="span3"></div>   
                                    <div class="span2"><button class="btn btn-info btn-bg contact-us" type="submit">Update</button></div></div>
                                    <div class="span7"></div>   
                        </form>
                    </div>
                </div>
                <div class="span2"></div>
            </div>
        </div>
    </div>
</div>