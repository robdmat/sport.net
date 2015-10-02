<?php
if (!isUserLoggedIn()):
    ?>
    <div class="banner text_center table">
        <div>
            <div class="text">Create your personalized newsfeed now
                <div style="width: 100%" id="appendmsg"></div>
            </div>
            <ul class="social">
                <li class="fb">
                    <a id="facebook" href="javascript:void(0)" title="Connect with Facebook">Connect with Facebook</a>
                </li>
                <li class="tw">
                    <a href="#">Start with Twitter</a>
                </li>
                <li class="gp">
                    <a href="javascript:void(0)" id="googleplus">Signup with Google</a>
                </li>
            </ul>
            <div class="small_text">
                <a class="btn btn-primary btn-lg pointer" data-toggle="modal" data-target="#loginModel">Sign with email and password</a><br>
                <a class="btn btn-primary btn-lg pointer" data-toggle="modal" data-target="#modalRegister">Sign Up</a>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="banner text_center table">
        <div class="adContainer">
            <?php echo headerAdContent(); ?>
        </div>
    </div>
<?php endif; ?>