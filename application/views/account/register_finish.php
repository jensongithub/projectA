<div id="content" class='container'>
	<div class="content">		
		<div class="container">
			<h3><?php echo lang('register_success_message'); ?></h3>
			<div class='yellow-box'>
				<p><span class='form-label'><?php echo lang('email'); ?></span><?php echo $this->input->post('email'); ?></p>
				<p><span class='form-label'><?php echo lang('firstname'); ?></span><?php echo $this->input->post('firstname'); ?></p>
				<p><span class='form-label'><?php echo lang('lastname'); ?></span><?php echo $this->input->post('lastname'); ?></p>
				<p><span class='form-label'><?php echo lang('phone'); ?></span><?php echo $this->input->post('phone'); ?></p>
				<p><span class='form-label'><?php echo lang('gender'); ?></span><?php echo $this->input->post('gender'); ?></p>
			</div>
		</div>
	</div>
</div>