@extends('layouts.master')
@section('title')
	قائمة المنتجات	
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		@if (session()->has('Add'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong >{{session()->get('Add')}} </strong>
							<button class="close" data-dismiss="alert" type="button" aria-label="Close" >
								<span aria-hidden="true">&times;</span>	
							</button>

						</div>

						
					@endif
					@if (session()->has('Error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong >{{session()->get('Error')}} </strong>
						<button class="close" data-dismiss="alert" type="button" aria-label="Close" >
							<span aria-hidden="true">&times;</span>	
						</button>

					</div>

					
				@endif
				@if (session()->has('Edit'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong >{{session()->get('Edit')}} </strong>
						<button class="close" data-dismiss="alert" type="button" aria-label="Close" >
							<span aria-hidden="true">&times;</span>	
						</button>

					</div>

					
				@endif
			
@endsection
@section('content')
				<!-- row -->
				<div class="row">
					
					
	
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">إضافة منتج</a>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50' >
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">إسم المنتج</th>
												<th class="border-bottom-0"> الوصف</th>
												<th class="border-bottom-0"> القسم</th>
												<th class="border-bottom-0">العمليات</th>
												


											</tr>
										</thead>
										<tbody>
											@foreach ($products as $product)
												
											
											<tr>
												<td>{{$product->id}}</td>
												<td>{{$product->product_name}}</td>
												<td>{{$product->description}}</td>
												<td>{{$product->section->section_name}}</td>
												<td>
													<button class="btn btn-outline-success btn-sm"
														data-product_name="{{ $product->product_name }}"
														 data-id="{{ $product->id }}"
														data-section_name="{{ $product->section->section_name }}"
														data-description="{{ $product->description }}" data-toggle="modal"
														data-target="#edit_Product">تعديل</button>

													<button class="btn btn-outline-danger btn-sm " data-id="{{ $product->id }}"
														data-product_name="{{ $product->product_name }}" data-toggle="modal"
														data-target="#modaldemo9">حذف</button>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					
				
				</div>

				<div class="modal" id="modaldemo8">
					<div class="modal-dialog" role="document">
						<div class="modal-content modal-content-demo">
							<div class="modal-header">
								<h6 class="modal-title">إضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
							<form action="{{route('products.store')}} " method="POST" autocomplete="off" >
								@csrf

							<div class="modal-body">
									<div class="form-group">
										<label for="section">إسم المنتج</label>
										<input class="form-control" type="text" name="product_name" id="section">
									</div>
									<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
									<select name="section_id" id="section_id" class="form-control" required>
										<option value="" selected disabled> --حدد القسم--</option>
										@foreach ($sections as $section)
											<option value="{{$section->id}}">{{ $section->section_name }}</option>
										@endforeach
									</select>
									<div class="form-group">
										<label for="desc">الوصف</label>
										<textarea class="form-control"  name="description" id="desc" cols="30" rows="5"></textarea>
									</div>

								
							</div>
							<div class="modal-footer">
								<button class="btn ripple btn-primary" type="submit">تاكيد</button>
								<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
					{{-- end Modal --}}
					<div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							@if (count($products)> 0 )
								
							
							<form action='{{route('products.update',$product->id)}}' method="post">
								{{ method_field('patch') }}
								{{ csrf_field() }}
								<div class="modal-body">
		
									<div class="form-group">
										<label for="title">اسم المنتج :</label>
		
										<input type="hidden" class="form-control" name="id" id="id" value="">
		
										<input type="text" class="form-control" name="product_name" id="Product_name">
									</div>
		
									<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
									<select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
										@foreach ($sections as $section)
											<option >{{ $section->section_name }}</option>
										@endforeach
									</select>
		
									<div class="form-group">
										<label for="des">ملاحظات :</label>
										<textarea name="description" cols="20" rows="5" id='description'
											class="form-control"></textarea>
									</div>
		
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">تعديل البيانات</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
								</div>
							</form>
							@endif
						</div>
					</div>
				</div>

				<div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
                        <h5 class="modal-title">حذف المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					@if (count($products) > 0)
						
					
                    <form action="{{route('products.destroy',$product->id)}} " method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
					@endif
                </div>
            </div>
        </div>
			   </div>
			   {{-- delete --}}
		

   </div>

			</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<script>
	$('#edit_Product').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var product_name = button.data('product_name')
		var section_name = button.data('section_name')
		var id = button.data('id')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #Product_name').val(product_name);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #id').val(id);
	})

			


	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var product_name = button.data('product_name')
		var modal = $(this)

		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #product_name').val(product_name);
	})

</script>
@endsection