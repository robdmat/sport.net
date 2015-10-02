<div class="container" style="position: relative;z-index: 1000;background: #fff">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8">
                <h3><?php echo $this->lang->line("register_title"); ?></h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras rhoncus malesuada magna, quis mattis metus iaculis vel. Vestibulum ut sapien et erat tempus imperdiet vel sit amet tortor. Aenean urna lorem, malesuada in tempus ac, aliquet at mauris. Vestibulum turpis mauris, hendrerit in ipsum ac.
                </p>
                <img src="http://www.parttimejobsoffer.com/images/register_now.jpg"/>
                <p>
                    <strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </strong>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras rhoncus malesuada magna, quis mattis metus iaculis velestibulum.
                </p>
            </div> 
            <div class="span4">
                <div id="register_form">
                    <h3><?php echo $this->lang->line("create_account"); ?></h3>
                    <?php
                    $attributes = array('class' => 'register', 'id' => 'register_form');
                    echo form_open('user/register/');
                    ?>
                    <?php
                    echo form_input(array(
                        'name' => 'email',
                        'id' => 'email',
                        'placeholder' => 'Email',
                        'maxlength' => '100',
                        'size' => '50',
                        'class' => form_error('email') ? 'is_error' : '',
                        'onkeydown' => 'javascript:removeError(this);',
                        'value' => set_value('email')
                    ));
                    echo form_error('email', '<div class="error">', '</div>');
                    echo form_error('username', '<div class="error">', '</div>');
                    echo form_password(array(
                        'name' => 'password',
                        'id' => 'password',
                        'placeholder' => 'Password',
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
                        'placeholder' => 'Confirm Password',
                        'maxlength' => '100',
                        'size' => '50',
                        'class' => form_error('confirm_password') ? 'is_error' : '',
                        'onkeydown' => 'javascript:removeError(this);',
                        'value' => set_value('confirm_password')
                    ));
                    echo form_error('confirm_password', '<div class="error">', '</div>');

                    echo form_submit('registerUser', 'Create Account');
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>