<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="span5 middle_align">
                
                <?php
                $attributes = array('class' => 'common_form', 'id' => 'recover_username');
                echo form_open('user/recover_username/', $attributes);

                echo '<h3>Forget username</h3>';
                
                echo form_label('Enter your email and we\'ll send you your username.', 'email');

                echo form_input(array(
                    'name' => 'email',
                    'class' => form_error('email') ? 'is_error' : '',
                    'onkeydown' => 'javascript:removeError(this);',
                    'value' => set_value('email'),
                    'placeholder' => 'Email'
                ));
                echo form_error('email', '<div class="error">', '</div>');
                
                echo form_submit('recoverUsername', 'Send username');
                
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>