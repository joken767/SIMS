
@extends('layouts.app')

@section('content')
@include('layouts.dashboard.sidebar')
@if (Auth::user ()->id == 1)
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">Suggested PPMP Requests for the ITC Unit/Office</h1>
		<div class="table-responsive">
			<table class="table table-stripped">
				<thead>
					<td>#</td>
					<td>Complete Code</td>
					<td>Stock Description</td>
					<td>Quantity</td>
					<td>Quarter of Issuance</td>
					<td>Actions</td>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>155-001-002-003</td>
						<td>Bond Paper, A4</td>
						<td>60</td>
						<td>1st</td>
						<td>
							<table>
								<tr>
									<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
									<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
									<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td>2</td>
						<td>155-051-102-063</td>
						<td>HBW Ballpen, Black, 0.5 mm</td>
						<td>15</td>
						<td>1st</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>3</td>
						<td>155-071-002-073</td>
						<td>Stapler</td>
						<td>2</td>
						<td>1st</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>4</td>
						<td>155-001-002-008</td>
						<td>Mouse, A4 Tech</td>
						<td>4</td>
						<td>1st</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>5</td>
						<td>155-008-007-003</td>
						<td>Bond Paper, Short/Medium</td>
						<td>120</td>
						<td>2nd</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>6</td>
						<td>155-001-072-103</td>
						<td>Ballpen, Faber Castelle, Red, 0.5 mm</td>
						<td>5</td>
						<td>2nd</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>7</td>
						<td>155-001-102-003</td>
						<td>Printer Ink, Black, Cartridge Type</td>
						<td>1</td>
						<td>3rd</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>8</td>
						<td>155-011-102-003</td>
						<td>Mouse, Imation</td>
						<td>2</td>
						<td>3rd</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>9</td>
						<td>155-011-008-003</td>
						<td>Keyboard, A4 Tech</td>
						<td>6</td>
						<td>4th</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>10</td>
						<td>155-101-002-093</td>
						<td>Desk, Mahogany Brown</td>
						<td>1</td>
						<td>4th</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>

					<tr>
						<td>11</td>
						<td>155-011-102-013</td>
						<td>Bond Paper, Long</td>
						<td>50</td>
						<td>4th</td>
						<td>
								<table>
									<tr>
										<td>{{ Form::submit ('Confirm', ['class' => 'btn btn-success']) }}</td>
										<td>{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</td>
										<td>{{ Form::submit ('Remove', ['class' => 'btn btn-danger']) }}</td>
									</tr>
								</table>
							</td>
					</tr>
				</tbody>
			</table>
			{{ Form::submit ('Submit Suggested PPMP Request', ['class' => 'btn btn-success']) }} &nbsp;&nbsp;&nbsp; <span>{{ Form::submit ('Manually Make PPMP Request', ['class' => 'btn btn-primary']) }}</span>
		</div>
	</div>
	@endif
@endsection