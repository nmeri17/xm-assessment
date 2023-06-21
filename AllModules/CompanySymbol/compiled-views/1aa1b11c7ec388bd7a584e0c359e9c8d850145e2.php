<?php $__env->startSection("scripts"); ?>

	<!--<script src="https://cdnjs.com/libraries/Chart.js"></script>

	<script>
	    const myChart = new Chart(ctx, {...});
	</script>-->
<?php $__env->stopSection(); ?>

<layout title="Showing Historical data for <?php echo e($companyName); ?>">

	<main>
		<table>
			<tr>
				<th>Date</th>
				<th>Open</th>
				<th>High</th>
				<th>Low</th>
				<th>Close</th>
				<th>Volume</th>
			</tr>

			<?php $__currentLoopData = $historicData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pieceOfHistory): $__env->incrementLoopIndices(); $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($pieceOfHistory->date); ?></td>
					<td><?php echo e($pieceOfHistory->open); ?></td>
					<td><?php echo e($pieceOfHistory->high); ?></td>
					<td><?php echo e($pieceOfHistory->low); ?></td>
					<td><?php echo e($pieceOfHistory->close); ?></td>
					<td><?php echo e($pieceOfHistory->volume); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $__env->getLastLoop(); ?>
		</table>

		<h3>Open/close chart</h3>

		<div>//do charty stuff</div>
	</main>
</layout><?php /**PATH C:\wamp64\www\AwesomeProject\AllModules\CompanySymbol\Markup/partials/show-symbols-chart.blade.php ENDPATH**/ ?>