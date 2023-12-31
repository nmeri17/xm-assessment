<x-layout page_title="Show Symbols">
	
	<x-slot:scripts>
		<script src="/js/index.js"></script>
	</x-slot>
	
	<main>
		<h3>fill the form below</h3>
		<form method="post" action="/symbol/submit-symbol">

			<input type="hidden" name="_csrf_token" value="{{$csrf_token}}">

			<select required name="symbol">

				<option selected="true" disabled="disabled">select symbol</option>

				@foreach($allSymbols as $symbolObject)
					<option value="{{$symbolObject['Symbol']}}">
					
						{{$symbolObject['Company Name']}}
					</option>
				@endforeach
			</select>

			<br>

			<label>Start date: </label>
			<input type="date" name="start_date" required min="{{date('Y-m-d')}}" value="{{@$payload_storage['start_date']}}">

			<br>

			<label>End date: </label>
			<input type="date" name="end_date" required min="{{date('Y-m-d')}}" value="{{@$payload_storage['end_date']}}">

			<br>

			<label>Email: </label>
			<input type="email" name="report_to" required value="{{@$payload_storage['report_to']}}">

			<br>

			<input type="submit" value="fetch details">
		</form>

		@isset ($validation_errors)
			
			<div id="validation-errors">
				<h3>Validation errors</h3>

				<ul>
					@foreach($validation_errors as $key => $error)

						<li class="error">

							{{$key . ":". implode("\n", $error)}}
						</li>
					@endforeach
				</ul>
			</div>
		@endisset
	</main>
</x-layout>