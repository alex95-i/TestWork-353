jQuery(document).ready(function( $ ) {
$( "#woo_custom_form_create" ).submit(function( event ) {
   event.preventDefault();

    let form_elm = $(this);
    let action = form_elm.data('action');
    let form_data = new FormData();
    let name   = $(this).find('input[name=product_name]').val();
    let price  = $(this).find('input[name=product_price]').val();
    let date   = $(this).find('input[name=product_date]').val();
    let select = $(this).find('select[name=product_select]').val();
    let nonce  = $(this).find('input[name=product_create]').val();

    form_data.append('action', action);
    form_data.append('file', $('input[name=product_img]')[0].files[0]);
    form_data.append('name', name);
    form_data.append('price', price);
    form_data.append('date', date);
    form_data.append('select', select);
    form_data.append('nonce', nonce);

    $.ajax({
                url:ajaxurl,
                type:"POST",
                processData: false,
                contentType: false,
                cache: false,
                data:  form_data,
                success : function( response ){
                   alert(JSON.parse(response));                 
                },
            });
});
});