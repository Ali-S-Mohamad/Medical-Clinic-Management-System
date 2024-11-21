@extends('layouts.master')

@section('title')

@endsection

@section('css')

@endsection


@section('content')
 <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Patients</h4>
                    </div>
                </div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-border table-striped custom-table datatable mb-0">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>birth date</th>
										<th>photo</th>
										<th>insurance Number</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td> Jennifer Robinson</td>
										<td>jenniferrobinson@example.com</td>
										<td>1/1/1977</td>
										<td>
                                        <img width="28" height="28" src="assets/img/user.jpg" class="rounded-circle m-r-5" alt="">
										</td>
										<td>(207) 808 8863</td>
									</tr>   
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
@endsection

@section('scripts')

@endsection