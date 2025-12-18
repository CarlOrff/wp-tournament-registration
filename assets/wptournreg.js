jQuery(function() {
  jQuery(".wptournreg-list table").tablesorter({widgets: ["zebra"],});
});

/* Change selected player in editor. */
jQuery( '.wptournregedit-select' ).on( 'change', function() {

	jQuery( '.wptournregedit-participant' ).css( 'display', 'none' );
	jQuery( jQuery( this ).val() ).css( 'display', 'block' );
	
}).trigger( 'change' );

/* Approve player. */
jQuery( '.wptournregedit-participant').each( function() {
	
	let form = jQuery( this );
	let select = jQuery( '.wptournregedit-select>[value="#wptournregedit-participant' + form.find( '[name=id]' ).val() + '"]' );
	form.find( '[name=approved]' ).on( 'change', function() {
		
		if ( jQuery( this ).is( ':checked' ) ) {
			
			select.removeClass( 'wptournregedit-not-approved' );
		}
		else {
			
			select.addClass( 'wptournregedit-not-approved' );
		}
	});
});

/* Check for bots */
var wptournregtouched = false;
jQuery( '.wptournreg-form input' ).on( 'focus mouseover touch', function() {
	
	if ( wptournregtouched === false ) {
		
		wptournregtouched = true;
		jQuery( '.wptournreg-form' ).prepend( '<input type="hidden" name="touched" value="1">' );
	}
});

var wptournregsuggestions = false;
jQuery( '.wptournreg-form [data-field-suggestions]').on( 'mouseover touchover', function() {
	
	if ( wptournregsuggestions === false ) {
		
		wptournregsuggestions = true;
		let elem = jQuery( this );
		let arr = elem.data('field-suggestions').split(',');
		let dataList = [];
		
		for (let index = 0; index < arr.length; ++index) {
			const element = arr[index];
			const value = 
			dataList[index] = { name:element, value:element.replace(/\s+/g, '&nbsp;') }
		}
		
		elem.inputDropdown(dataList, {
			formatter: data => {
			return `<li language=${data.value}>${data.name}</li>`
		},
			valueKey: 'language' // default: data-value
		})
		elem.removeData( 'field-suggestions' );
	}
});