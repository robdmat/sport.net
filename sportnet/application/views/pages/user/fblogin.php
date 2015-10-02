<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="span5 middle_align">
                <?php
                $attributes = array('class' => 'common_form', 'id' => 'password_reset');
                echo form_open('user/fblogin/', $attributes);

                echo '<h3>Set username and password</h3>';
                echo form_input(array(
                    'name' => 'username',
                    'id' => 'username',
                    'placeholder' => $this->lang->line('username'),
                    'maxlength' => '100',
                    'size' => '50',
                    'class' => form_error('username') ? 'is_error' : '',
                    'onkeydown' => 'javascript:removeError(this);',
                    'value' => set_value('username')
                ));
                echo form_error('username', '<div class="error">', '</div>');

                echo form_password(array(
                    'name' => 'password',
                    'id' => 'password',
                    'placeholder' => $this->lang->line('password'),
                    'maxlength' => '100',
                    'size' => '50',
                    'class' => form_error('password') ? 'is_error' : '',
                    'onkeydown' => 'javascript:removeError(this);',
                    'value' => set_value('password')
                ));
                echo form_error('password', '<div class="error">', '</div>');
                echo form_password(array(
                    'name' => 'confirm_password',
                    'id' => 'confirm_password',
                    'placeholder' => $this->lang->line('confirm_password'),
                    'maxlength' => '100',
                    'size' => '50',
                    'class' => form_error('confirm_password') ? 'is_error' : '',
                    'onkeydown' => 'javascript:removeError(this);',
                    'value' => set_value('confirm_password')
                ));
                echo form_error('confirm_password', '<div class="error">', '</div>');
                echo form_submit('register', $this->lang->line('create_account'));
                echo form_close();
                ?>
                <!-- /.middle_align div --></div>
        </div>
    </div>
</div>