@section("scripts")

	<!--<script src="https://cdnjs.com/libraries/Chart.js"></script>

	<script>
	    const myChart = new Chart(ctx, {...});
	</script>-->
@endsection

<layout title="Showing Historical data for {{$companyName}}">

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

			@foreach ($historicData as $pieceOfHistory)
				<tr>
					<td>{{$pieceOfHistory->date}}</td>
					<td>{{$pieceOfHistory->open}}</td>
					<td>{{$pieceOfHistory->high}}</td>
					<td>{{$pieceOfHistory->low}}</td>
					<td>{{$pieceOfHistory->close}}</td>
					<td>{{$pieceOfHistory->volume}}</td>
				</tr>
			@endforeach
		</table>

		<h3>Open/close chart</h3>

		<div>//do charty stuff</div>
	</main>
</layout>