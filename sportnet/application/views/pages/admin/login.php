<div id="login">   
    <div class="form-signin">
        <?php echo $this->session->flashdata('info'); ?>
        <form class="form-horizontal" action="<?php echo site_url('admin/login'); ?>" method="POST">
            <fieldset>
                <legend><?php echo 'Admin Login'; ?></legend>
                <div class="control-group">
                    <label for="focusedInput" class="control-label"><?php echo 'Email'; ?></label>
                    <div class="controls">
                        <input type="text" name="email" placeholder="Email" id="focusedInput" class="input-xlarge focused <?php echo form_error('username') ? 'is_error' : ''; ?> " onkeydown="javascript:removeError(this);">
                        <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo 'Password'; ?></label>
                    <div class="controls">
                        <input type="password" name="password" placeholder="Password" id="focusedInput" class="input-xlarge focused <?php echo form_error('password') ? 'is_error' : ''; ?>" onkeydown="javascript:removeError(this);">
                        <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Sign In</button>
                    <button class="btn" type="reset">Cancell</button>
                </div>
            </fieldset>
        </form>

    </div>
</div>
