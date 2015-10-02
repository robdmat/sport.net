<div class="container" style="background: #fff">
    <div class="row-fluid">
        <div class="span12">
            <div class="span5 middle_align">

                <?php
                $attributes = array('class' => 'common_form', 'id' => 'password_reset');
                echo form_open('user/password_reset/', $attributes);
                echo '<h3>Reset password</h3>';
                echo form_input(array(
                    'name' => 'email',
                    'class' => form_error('email') ? 'is_error' : '',
                    'onkeydown' => 'javascript:removeError(this);',
                    'value' => set_value('email'),
                    'placeholder' => 'Email'
                ));
                echo form_error('email', '<div class="error">', '</div>');

                echo form_submit('resetPassword', 'Reset password');

                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>