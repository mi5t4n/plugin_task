<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sagartamang.com.np
 * @since      1.0.0
 *
 * @package    Plugi\Task
 * @subpackage Plugin\Task\Templates
 */
?>

<div class="wrap">
	<h1><?php esc_html_e( 'Plugin Task', 'plugin-task' ); ?></h1>

	<form method="post" action="options.php" id="plugin-task-form">
	<?php
		/**
		 * Nonces, actions and referrers.
		 */
		wp_nonce_field( 'plugin-task' );

	?>
		<table class="form-table">
			<tbody>
				<!-- Full name -->
				<tr>
					<th scope="row">
						<label for="fullname">
							<?php esc_html_e( 'Full Name', 'plugin-task' ); ?>
						</label>
					</th>
					<td>
						<input type="text" id="fullname" name="fullname" />
					</td>
				</tr>

				<!-- Result -->
				<tr>
					<th scope="row">
						<label for="result">
							<?php esc_html_e( 'Result', 'plugin-task' ); ?>
						</label>
					</th>
					<td>
						<textarea disabled type="text" id="result" rows="15" cols="60"></textarea>
					</td>
				</tr>

			</tbody>
		</table>
		<span class="spinner"></span>
		<button type="submit" name="submit" id="submit"
			class="button button-primary"
			value="submit">
			<?php esc_html_e( 'Submit', 'plugin-task' ); ?>
		</button>
	</form>
</div>
<?php
