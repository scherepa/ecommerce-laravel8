let $sidebar = $('#sidebar');
 $('#menubtn').click(function() {
     $sidebar.toggleClass('fixed inset-0 h-screen')
    $sidebar.toggleClass('hidden');
    $('#menubtn').toggleClass('hidden');    
});
$('#closebtn').click(function() {
    $sidebar.toggleClass('fixed  inset-0 h-screen');
    $sidebar.toggleClass('hidden');
    $('#menubtn').toggleClass('hidden');    
});
let mail_menu = $('.mail-menu');
let mail_wrap = $('#mail_wrap');
let inter=$('#interface_wrap');
let interface_menu = $('.interface-menu');
let appwrap=$('#app_wrap');
let brand_menu = $('.brand-menu');
let cat=$('#categories_wrap');
let cat_menu = $('.category-menu');
let prod_menu = $('.prod-menu');
let prod_wrap = $('#prod_wrap');
let coup_wrap = $('#coup_wrap');
let coup_menu = $('.coup_menu');
let ship_wrap = $('#ship_wrap');
let ship_menu = $('.ship-menu');
function hideThis(x,y) {
    x.toggleClass('block');
    x.toggleClass('hidden');
    y.toggleClass('border-t border-gray-200 py-2');
}
$('#categories').click(()=>{hideThis(cat_menu,cat);});
$('#app_brand').click(()=>{hideThis(brand_menu,appwrap);});
$('#interface').click(()=>{hideThis(interface_menu,inter);});
$('#mail').click(()=>{hideThis(mail_menu,mail_wrap);});
$('#prod').click(()=>{hideThis(prod_menu,prod_wrap);});
$('#coup').click(()=>{hideThis(coup_menu,coup_wrap);});
$('#ship').click(()=>{hideThis(ship_menu,ship_wrap);});


