@extends('cp.user.user.tab')
@section ('section-title', "User's Zone")
@section ('tab-active-system-zone', 'active')
@section ('tab-css')

@endsection

@section ('tab-js')
<script type="text/javascript">
	$(document).ready(function(){
		$('.item').click(function(){
			check_id = $(this).attr('for');
			zone_id = $("#"+check_id).attr('zone-id');
			features(zone_id);
		})
	})
	function features(zone_id){
		$.ajax({
		        url: "{{ route($route.'.check-zone') }}?user_id={{ $id }}&zone_id="+zone_id,
		        type: 'GET',
		        data: { },
		        success: function( response ) {
		            if ( response.status === 'success' ) {
		            	toastr.success(response.msg);
		            }else{
		            	swal("Error!", "Sorry there is an error happens. " ,"error");
		            }
		        },
		        error: function( response ) {
		           swal("Error!", "Sorry there is an error happens. " ,"error");
		        }
		});
	}
</script>

@endsection

@section ('tab-content')
	<h4>Zone</h4>

	
		<div class="row m-t-lg">
			@foreach( $zones as $zone )
				@php( $check = "" )
		        @foreach($data as $row)
		            @if($row->zone_id == $zone->id)
		                @php( $check = "checked" )
		            @endif
		        @endforeach
				<div class="col-sm-6 col-sm-4 col-md-3 col-lg-3">
					<div class="checkbox-bird">
						<input type="checkbox" zone-id="{{ $zone->id }}" id="zone-{{ $zone->id }}" {{ $check }}>
						<label class="item" for="zone-{{ $zone->id }}">{{ $zone->name }} ({{count($zone->rooms)}} Rooms) </label>
					</div>
				</div>
			@endforeach
		</div>


@endsection