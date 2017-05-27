$(function () {

   $( '' ).prepend( function() {
       tagName = $( this ).prop( 'localName' );
       tagID = $( this ).prop( 'id' )? '#' + $( this ).prop( 'id' ) + ' ' : '';
       tagClass = $( this ).prop( 'className' )? '.' + $( this ).prop( 'className' ) : '';
       tagData = $( this ).attr( 'data-album' )? '[data-album=' + $( this ).attr( 'data-album' ) + ']' : '';
       return '<small>' + tagName + tagID +  '</small> ';
   } );
   
   /* 01-06   
   $( 'li' ).prepend( function() {
       tagName = $( this ).prop( 'localName' );
       tagID = $( this ).prop( 'id' )? '#' + $( this ).prop( 'id' ) + ' ' : '';
       tagClass = $( this ).prop( 'className' )? '.' + $( this ).prop( 'className' ) : '';
       tagData = $( this ).attr( 'data-album' )? '[data-album="' + $( this ).attr( 'data-album' ) + '"]' : '';
       return '<small>' + tagData + '</small> ';
   } );
   */
    
   /* 01-07 
   $( 'li' ).prepend( function() {
       tagName = $( this ).prop( 'localName' );
       tagID = $( this ).prop( 'id' )? '#' + $( this ).prop( 'id' ) + ' ' : '';
       tagClass = $( this ).prop( 'className' )? '.' + $( this ).prop( 'className' ) : '';
       tagData = $( this ).children().attr( 'alt' )? '[alt="' + $( this ).children().attr( 'alt' ) + '"]' : '';
       return '<small>' + tagData + '</small> ';
   } );
  */
  
});