
<style>
    :-moz-placeholder {
        color: #c9c9c9 !important;
        font-size: 13px;
    }

    ::-webkit-input-placeholder {
        color: #ccc;
        font-size: 13px;
    }

    input {
        font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif;
        font-size: 14px;
    }

    .containe input[type=text], .containe input[type=password] {
        margin: 5px;
        padding: 0 10px;
        width: 250px;
        height: 34px;
        color: #404040;
        background: white;
        border: 1px solid;
        border-color: #c4c4c4 #d1d1d1 #d4d4d4;
        border-radius: 2px;
        outline: 5px solid #eff4f7;
        -moz-outline-radius: 3px; // Can we get this on WebKit please?
    }

    .subMitButton {
        padding: 0 18px;
        height: 29px;
        font-size: 12px;
        font-weight: bold;
        color: #527881;
        text-shadow: 0 1px #e3f1f1;
        background: #cde5ef;
        border: 1px solid;
        border-color: #b4ccce #b3c0c8 #9eb9c2;
        border-radius: 16px;
        outline: 0;
    }

    .lt-ie9 {
        input[type=text], input[type=password] { line-height: 34px; }
    }
    .containerLogin {
        margin: 0px auto;
        width: 360px;
        padding: 100px 0px;
    }
    body.user{background: #fff}
    .containe{margin: 10px 0px}
    .containe input[type=submit]{
        display: inline-block;
        margin-left: 100px;
        vertical-align: top;
        line-height: 2em;
        padding-top: 0;
        font-weight: bold;
        color: #505050;
        text-align: center;
        text-shadow: 0 1px rgba(255,255,255,0.5);
        background: #eaefef;
        border: 0px white;
        border-radius: 2px;
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        height: 2em;
        padding-left: .625em;
        padding-right: .625em;
        cursor: pointer;
    }

</style>
<section class="containerLogin">

    <?php
    $attributes = array('class' => 'common_form', 'id' => 'password_reset');
    echo form_open('user/recover_password/', $attributes);
    echo '<h3>Recover password</h3>';
    ?>
    <p class="containe">
        <?php
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
        ?>
    </p><p class="containe">
        <?php
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
        ?>
    </p>
    <?php
    echo form_hidden('auth', $this->input->get('auth'));
    echo form_hidden('email', $this->input->get('user'));
    ?>
    <p class="containe">
        <?php echo form_submit('recoverPassword', 'Update Password');
        ?></p>
    <?php
    echo form_close();
    ?>
</div>
</section>