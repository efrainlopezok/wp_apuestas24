// Miguel Fuentes | fuentessoft@gmail.com / mfuentes@staff.digital

(function( $, document, window, undefined ) {

	//var style = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
	var style = [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}]

	function AnimatedMarker(options) {
		this.latlng_ = options.position;
		this.setMap(options.map);
	}
	AnimatedMarker.prototype = new google.maps.OverlayView();
	AnimatedMarker.prototype.draw = function() {
		var me = this;
		var div = this.div_;
		if (!div) {
			div = this.div_ = $('' +
				'<div><div class="animated-dot">' +
				'<div class="middle-dot"></div>' +
				'<div class="signal"></div>' +
				'<div class="signal2"></div>' +
				'</div></div>' +
			'')[0];
			div.style.position = 'absolute';
			div.style.paddingLeft = '0px';
			div.style.cursor = 'pointer';
			var panes = this.getPanes();
			panes.overlayImage.appendChild(div);
		}
		var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
		if (point) {
			div.style.left = point.x + 'px';
			div.style.top = point.y + 'px';
		}
	};
	AnimatedMarker.prototype.remove = function() {
		if (this.div_) {
			this.div_.parentNode.removeChild(this.div_);
			this.div_ = null;
		}
	};
	AnimatedMarker.prototype.getPosition = function() {
		return this.latlng_;
	};

	function init(){
		var $maps = $(".wrapper_gmaps");
		if($maps.length){
			$maps.each(function(i, e){
				var latlng = new google.maps.LatLng($(this).data("lat"), $(this).data("lng")),
					map = new google.maps.Map(this, {
						styles: style,
						center: latlng,
						zoom: 17,
						mapTypeControlOptions: {
							mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
						},
						scrollwheel: false,
						panControl: false,
						zoomControl: true,
						zoomControlOptions: {
							style: google.maps.ZoomControlStyle.LARGE,
							position: google.maps.ControlPosition.LEFT_CENTER
						},
						mapTypeControl: false,
						scaleControl: false,
						streetViewControl: true
				    	}),
	                    marker_options = {
	                    position: latlng,
	                    map: map
	                }, marker;
	            //console.log($(this).data("marker-type"));
	            switch($(this).data("marker-type")){
	            	case "animated":
	            		marker = new AnimatedMarker(marker_options);
	            	break;
	            	case "image":
	            		marker_options.icon = $(this).data("marker-image");
	            	default:
	            		marker = new google.maps.Marker(marker_options);
	            }

	            $(this).data("map",map);
	            $(this).data("marker",marker);
			});
		}
	};

	$( document ).ready( init );

})( jQuery, document, window );