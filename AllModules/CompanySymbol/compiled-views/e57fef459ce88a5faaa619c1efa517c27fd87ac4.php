<layout title="Show Symbols">

	<main>
		<h3>fill the form below</h3>
		<form method="post" action="/symbol/submit-symbol">

			<input type="hidden" name="_csrf_token" value="<?php echo e($csrf_token); ?>">

			<select required name="symbol">

				<option selected="true" disabled="disabled">select symbol</option>

				<?php $__currentLoopData = $allSymbols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $symbolObject): $__env->incrementLoopIndices(); $__env->getLastLoop(); ?>
					<option value="<?php echo e($symbolObject['Symbol']); ?>">
					
						<?php echo e($symbolObject['Company Name']); ?>

					</option>
				<?php endforeach; $__env->popLoop(); $__env->getLastLoop(); ?>
			</select>

			<br>

			<label>Start date: </label>
			<input type="date" name="start_date" required min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(@$payload_storage['start_date']); ?>">

			<br>

			<label>End date: </label>
			<input type="date" name="end_date" required min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(@$payload_storage['end_date']); ?>">

			<br>

			<label>Email: </label>
			<input type="email" name="report_to" required value="<?php echo e(@$payload_storage['email']); ?>">

			<br>

			<input type="submit" value="fetch details">
		</form>

		<?php if(isset($validation_errors)): ?>
			
			<div id="validation-errors">
				<h3>Validation errors</h3>

				<ul>
					<?php $__currentLoopData = $validation_errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $error): $__env->incrementLoopIndices(); $__env->getLastLoop(); ?>

						<li class="error">

							<?php echo e($key . ":". implode("\n", $error)); ?>

						</li>
					<?php endforeach; $__env->popLoop(); $__env->getLastLoop(); ?>
				</ul>
			</div>
		<?php endif; ?>
	</main>
</layout><?php /**PATH C:\wamp64\www\AwesomeProject\AllModules\CompanySymbol\Markup/partials/show-symbols.blade.php ENDPATH**/ ?>