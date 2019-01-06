@extends($route.'.main')
@section ('section-title', 'Create New User')
@section ('section-css')
	<link href="{{ asset ('public/cp/css/plugin/fileinput/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset ('public/cp/css/plugin/fileinput/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
	<!-- some CSS styling changes and overrides -->
	<style>
		.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
		    margin: 0;
		    padding: 0;
		    border: none;
		    box-shadow: none;
		    text-align: center;
		}
		.kv-avatar .file-input {
		    display: table-cell;
		    max-width: 220px;
		}
	</style>
@endsection

@section ('imageuploadjs')
    <script type="text/javascript" src="{{ asset ('public/cp/js/plugin/fileinput/fileinput.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset ('public/cp/js/plugin/fileinput/theme.js') }}" type="text/javascript"></script>
@endsection

@section ('section-js')
	<script type="text/JavaScript">
		$(document).ready(function(event){
		
			$('#form').validate({
				modules : 'file',
				submit: {
					settings: {
						inputContainer: '.form-group',
						errorListClass: 'form-tooltip-error'
					}
				}
			}); 
			
		}); 
		
	</script>

	

	<script>
		
		var btnCust = ''; 
		$("#avatar").fileinput({
		    overwriteInitial: true,
		    maxFileSize: 1500,
		    showClose: false,
		    showCaption: false,
		    showBrowse: false,
		    browseOnZoneClick: true,
		    removeLabel: '',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-2',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="{{ asset('public/user/img/avatar.png') }}" alt="Missing Image" class="img img-responsive"><span class="text-muted">Click to select <br /><i style="font-size:12px">Image dimesion must be 200x165 with .jpg or .png type</i></span>',
		    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
		    allowedFileExtensions: ["jpg", "png", "gif"]
		});
	</script>
@endsection

@section ('section-content')
	<div class="container-fluid">
		
		@php ($name = "")
		@php ($email = "")
		@php ($phone = "")
        @php ($status = "")
       	@if (Session::has('invalidData'))
            @php ($invalidData = Session::get('invalidData'))
            @php ($name = $invalidData['name'])
            @php ($email = $invalidData['email'])
            @php ($phone = $invalidData['phone'])
            @php ($status = $invalidData['status'])
       	@endif
       	@include('cp.layouts.error')
		<form id="form" action="{{ route($route.'.store') }}" name="form" method="POST"  enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="email">Name</label>
			<div class="col-sm-10">
				<input 	id="name"
						name="name"
						value = "{{ $name }}"
						type="text"
						placeholder = "Eg. Savan"
					   	class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="email">Email</label>
			<div class="col-sm-10">
				<input 	id="email"
						name="email"
						value = "{{ $email }}"
						type="text"
						placeholder = "Eg. you@example.com"
					   	class="form-control"
					   	data-validation="[EMAIL]">
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 form-control-label" for="phone">Phone</label>
			<div class="col-sm-10">
				<input 	id="phone"
						name="phone"
					   	value = "{{ $phone }}"
					   	type="text" 
					   	placeholder = "Eg. 093123457"
					   	class="form-control"
					   	data-validation="[L>=9, L<=10, numeric]"
						data-validation-message="$ is not correct." 
						data-validation-regex="/(^[00-9].{8}$)|(^[00-9].{9}$)/"
						data-validation-regex-message="$ must start with 0 and has 10 or 11 digits" />
						
			</div>
		</div>
		
		<div class="form-group row">
			<label for="position_id" class="col-sm-2 form-control-label">Position</label>
			<div class="col-sm-10">
				<select id="position_id" name="position_id" class="form-control">
					<option value="1" >Admin</option>
					<option value="2" >User</option>
				</select>
			</div>
		</div>

			<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="password">Password</label>
				<div class="col-sm-10">
					<input 	id="password"
							name="password"
						   	value = ""
						   	type="password"
						   	placeholder = ""
						   	class="form-control"
						   	data-validation="[L>=6, L<=18]"
							data-validation-message="$ must be between 6 and 18 characters." />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="confirm_password">Confirm Password</label>
				<div class="col-sm-10">
					<input 	id="confirm_password"
							name="confirm_password"
						   	value = ""
						   	type="password"
						   	placeholder = ""
						   	class="form-control"
						   	data-validation="[L>=6, L<=18]"
							data-validation-message="$ must be between 6 and 18 characters." />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="email">Avatar</label>
				<div class="col-sm-10">
					<div class="kv-avatar center-block">
				        <input id="avatar" name="avatar" type="file" class="file-loading">
				    </div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="kh_content">Status</label>
				<div class="col-sm-10">
					<div class="checkbox-toggle">
						<input id="status-status" type="checkbox"  >
						<label onclick="booleanForm('status')" for="status-status"></label>
					</div>
					<input type="hidden" name="status" id="status" value="{{ $status }}">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 form-control-label"></label>
				<div class="col-sm-10">
					<button type="submit" class="btn btn-success"> <fa class="fa fa-plus"></i> Create</button>
				</div>
			</div>
		</form>
	</div>

@endsection