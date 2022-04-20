<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('discription')
    <title>E-com - @yield('title')</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/heb.css') }}">
    <link rel="stylesheet" href="{{ asset('fronted/assets/css/try.css') }}">
    @livewireStyles
    @yield('page_styles')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('page_header_scripts')
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <!-- Container  flex flex-col  w-full-->
    <div class="mx-auto px-4 bg-gray-900">
        @php
        $cats = App\Models\Category::get();
        @endphp
        <header>
            @include('layouts.fronted.header',['cats'=>$cats])
        </header>
        <!-- class="flex-1 flex flex-col" -->
        <div class="my-12">
            @yield('content')
        </div>
        <!-- Modal -->
        <div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="interestModal">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form>
                        <div class="bg-gradient-to-t from-purple-600 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center sm:mx-0 w-48 rounded-lg">
                                    <img src="" alt="" id="prod_img" class="object-cover">
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <span class="bg-green-100 rounded-full text-sm font-bold text-gray-800" id="aviable">
                                    </span>
                                    <span id="stockout" class="bg-gray-100 text-gray-900">
                                    </span>
                                    <h3 class="text-lg leading-6 font-bold text-gray-900  border-b-2 border-purple-700" id="modal-title">
                                    </h3>
                                    <h4 id="pbrand" class="text-base font-bold"></h4>
                                    <p class="font-bold text-xs">category:<span id="pcategory" class="text-xs font-semibold"></span></p>
                                    <p class="font-bold text-xs border-b-2 border-purple-600 pb-1">code: <span id="pcode" class="text-xs font-semibold"></span></p>
                                    <h3><strong id="pdisc" class="font-extrabold text-xl pt-1"></strong>
                                        <span class="text-xs line-through mx-auto" id="pprice"></span>
                                    </h3>
                                    <div class="mt-2 space-y-2 px-2">
                                        <p class="text-gray-500" id="modal-body">
                                        <div id="#chooseColor" class="font-bold text-sm text-red-500"></div>
                                        <div>
                                            <label for="color" class="text-sm font-bold">Choose Color</label>
                                            <select id="color" name="color" class="rounded-lg min-w-max mx-2 text-sm font-semibold">
                                            </select>
                                        </div>
                                        <div id="size-area">
                                            <label for="size" class="text-sm font-bold">Choose Size</label>
                                            <select id="size" name="size" class="rounded-lg min-w-max mx-2 text-sm font-semibold">
                                            </select>
                                        </div>
                                        <div>
                                            <label for="qty" class="text-sm font-bold">Qty</label>
                                            <input type="number" class="rounded-lg w-1/3 mx-2 text-sm font-semibold" id="qty" value="1" min="1" name="qty">
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="product_id">
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" id="add-to-cart-modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-8 py-2 bg-purple-600 text-base  text-white hover:bg-purple-700 sm:w-auto sm:text-sm" onclick="addToCart()">
                                <div class="sr-only">Add to Cart</div>
                                <span class="material-icons font-bold">
                                    add_shopping_cart
                                </span>
                            </button>
                            <button type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- EndModal -->
        <footer>
            @include('layouts.fronted.footer',['cats'=>$cats])
        </footer>
    </div>
    <script src="{{asset('fronted/assets/js/menu.js')}}"></script>
    @stack('modals')

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Start Product View with Modal 
        function productView(id) {
            $('#interestModal').removeClass('invisible');
            // alert(id)
            $.ajax({
                type: 'GET',
                url: '/product/view/modal/' + id,
                dataType: 'json',
                success: function(data) {
                    //console.log(data.size);
                    $('#prod_img').attr('src', data.img);
                    $('#modal-title').html(data.product.product_name_en);
                    $('#pcode').text(data.product.product_code);
                    $('#pcategory').text(data.product_cat);
                    $('#pbrand').text(data.product_brand);
                    $('#product_id').val(id);
                    $('#qty').val(1);
                    $('#color').empty();
                    $.each(data.color, function(key, value) {
                        //console.log(value);
                        $('select[name="color"]').append('<option value="' + value + '">' + value + '</option>');
                    });
                    $('#size').empty();
                    $('#size-area').hide();
                    //console.log($('#size-area'));
                    if (data.size != null) {
                        $('#size-area').show();
                        $.each(data.size, function(key, value) {
                            $('select[name="size"]').append('<option value="' + value + '">' + value + '</option>');
                        });
                    } else {
                        $('#size-area').hide();
                    }


                    if (!data.product.discount_price) {
                        $('#pprice').html("");
                        $('#pdisc').html("");
                        $('#pdisc').html(data.product.selling_price + "$");
                    } else {
                        $('#pprice').html(data.product.selling_price + "$");
                        $('#pdisc').html(data.product.discount_price + "$");
                    }
                    $('#aviable').text('');
                    $('#stockout').text('');
                    if (data.product.product_qty > 0) {
                        $('#aviable').text('InStock');
                        $('#add-to-cart-modal').show();
                    } else {
                        $('#stockout').text('Stockout');
                        $('#add-to-cart-modal').hide();
                    }
                    // console.log($('#qty').val());
                }
            });
            $('.closeModal').on('click', function(e) {
                $('#interestModal').addClass('invisible');
            });
        }
        //End Product View with Modal

        function miniCart() {
            $.ajax({
                type: 'GET',
                url: '/product/mini/cart',
                dataType: 'json',
                success: function(response) {
                    var miniCart = "";
                    //console.log(response)
                    $('#miniCart').html(response.cartQty);
                    $('#totalCart').html('$' + response.cartTotal);
                    $('#pricing').text(`Sub Total: $${response.cartSubTotal}`);
                    $.each(response.carts, function(key, value) {
                        var slug = (value.name.toLowerCase()).replace(' ', '');
                        miniCart += `
                        <div class="w-full md:w-4/12 my-2 p-1">
                        <div class="image md:flex justify-start"><img src="/${value.options.image}" alt="" class="object-contain w-1/2 mx-auto md:mx-0">
                        </div>
                        </div>
                        <div class="w-full md:w-8/12 flex justify-between p-1 my-2">
                        <div>
                        <span class="name"><a href="/product/details/${value.id}/${slug}">Name: ${value.name}</a></span>
                        <div class="price">Price * QTY: ${value.price} * ${value.qty}</div>
                        </div>
                        <div class="pr-1 pl-auto">
                        <button class="action text-red-500" type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="fa fa-times"></i></button>
                        </div>
                        </div>
                        `
                    });
                    $("#CartListTable").html(miniCart);
                }
            });
        }
        miniCart();

        /* Shopping Cart Add Product */
        function addToCart() {
            var product_name = $('#modal-title').text();
            var id = $('#product_id').val();
            var color = $('#color option:selected').text();
            if (!color) {
                $('#chooseColor').text('Choose the color, please');
            } else {
                var size = $('#size option:selected').text();
                var quantity = $('#qty').val();
                if (!($('#interestModal').hasClass('invisible'))) {
                    $('#interestModal').addClass('invisible');
                }
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        color: color,
                        size: size,
                        product_name: product_name,
                        quantity: quantity
                    },
                    url: "/cart/data/store/" + id,
                    success: function(data) {
                        if (data.success) {
                            miniCart();

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }


                        if (data.fail) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops... smth went wrong',
                                text: data.fail
                            });
                        }

                    },
                    failure: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... smth went wrong',
                            text: 'fail'
                        });
                    }
                });
            }
        }
        /* End Shopping Cart Add Product */

        /* add from single view */
        function addSingleToCart(go = false) {
            var product_name = $('#single-modal-title').text();
            //console.log(product_name);
            var id = $('#single_product_id').val();
            var color = $('#single-color option:selected').text();
            var size = $('#single-size option:selected').text();
            var quantity = $('#single-qty').val();
            if (!($('#interestModal').hasClass('invisible'))) {
                $('#interestModal').addClass('invisible');
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    color: color,
                    size: size,
                    product_name: product_name,
                    quantity: quantity
                },
                url: "/cart/data/store/" + id,
                success: function(data) {
                    if (data.success) {
                        miniCart();
                        if (!go) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            window.location.href = "{{url('/checkout')}}";
                        }
                    }
                    if (data.fail) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... smth went wrong',
                            text: data.fail
                        });
                    }

                },
                failure: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... smth went wrong',
                        text: 'fail'
                    });
                }
            });

        }

        /* end add from single view */
    </script>
    <script type="text/javascript">
        //remove from cart list
        function miniCartRemove(rowId) {
            $.ajax({
                type: 'GET',
                url: '/minicart/product-remove/' + rowId,
                dataType: 'json',
                success: function(data) {
                    miniCart();
                    cart();
                }
            });
        }
    </script>
    <!-- open close minicart list -->
    <script>
        function openMiniCartList() {
            $('#miniCartList').removeClass('hidden');
            $('#CartListTable').show();
        }

        function closeMiniCartList() {
            $('#miniCartList').addClass('hidden');
            $('#CartListTable').hide();
        }
    </script>

    <!-- add to wishlist -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Update Wishlist
        function addToWishlist(id) {
            // alert(id)
            $.ajax({
                type: 'POST',
                url: "/add-to-wishlist/" + id,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                    if (data.error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                }
            });
            $('.closeModal').on('click', function(e) {
                $('#interestModal').addClass('invisible');
            });
        }
    </script>
    <script type="text/javascript">
        function cart() {
            $.ajax({
                type: 'GET',
                url: '/user/get-cart-product',
                dataType: 'json',
                success: function(response) {
                    //console.log(response.carts.length);
                    if (response.carts.length == 0) {
                        $('.coupon-apply').hide();
                    }
                    if (response.coupon_name != "") {
                        $('.coupDetails').empty().html(`<button class="text-red-500 mr-2 rounded-lg px-1 bg-gray-200 hover:bg-white" type="submit" onclick="couponRemove()"><i class="fa fa-times"></i></button>Coupon ${response.coupon_name} Discount<span class="mx-2 text-red-500">-$${response.discount_amount}</span>`);
                    } else {
                        $('.coupDetails').empty();
                    }
                    $('.cart-grand-total').empty().html(`Grand Total<span class="mx-2 text-green-300">$${response.cartTotal}</span>`);
                    $('.cart-sub-total').empty().html(`Sub Total<span class="mx-2">$${response.cartSubTotal}</span>`);
                    $('.cart-tax').empty().html(`Tax(17%)<span class="mx-2">$${response.cartTax}</span>`);
                    var rows = "";
                    $.each(response.carts, function(key, value) {
                        var slug = (value.name.toLowerCase()).replace(' ', '');
                        rows += `<tr>
                        <td class="min-w-max"><img src="/${value.options.image}" alt="image" class="w-32 object-cover"></td>
                        <td class="min-w-max px-2">
                            <a href="/product/details/${value.id}/${slug}"><div class="hover:text-blue-300">${value.name}</div></a>
                            <div class="price">Price: $${value.price}</div>
                        </td>
                        <td class="px-2 item-color">
                            <strong>${value.options.color}</strong>
                        </td>
                        <td class="px-2 item-size">
                                      ${value.options.size == null ? `<span> .... </span>` : `<strong>${value.options.size} </strong>`}           
                        </td>
                        <td class="px-2 item-qty">
                            <div class="flex justify-center content-center">
                            <button type="submit" class="bg-green-500 w-12 rounded" name="${value.rowId}" onclick="cartIncrement(this.name)">+</button>
                            <input type="text" value="${value.qty}" min="1" max="100" class="text-gray-900 w-12 max-w-min rounded" disabled="">
                            <button type="submit" class="bg-red-500 w-12 rounded disabled:opacity-50 ${value.qty > 1 ? "":"cursor-not-allowed"}" name="${value.rowId}" onclick="cartDecrement(this.name)" ${value.qty > 1 ? "":"disabled"}>-</button>
                            </div>
                        </td>
                        <td class="px-2 item-subtotal">
                            <div class=" price">
                            ${value.subtotal}$
                            </div>
                        </td>

                        <td class="px-2 close-btn">
                             <div class="flex justify-center content-center">
                            <button type="submit" class="bg-red-500 p-2 rounded-lg" name="${value.rowId}"  onclick="cartRemove(this.name)"><i class="fa fa-times"></i></button>
                            </div>
                        </td>
                    </tr>`;
                    });
                    $('#cartPage').html(rows);
                }
            });
        }
        cart();
        //remove item from cart-page
        function cartRemove(id) {
            $.ajax({
                type: "GET",
                url: '/user/cart-remove/' + id,
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        cart();
                        miniCart();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                }
            });
        }

        //cartIncrement
        function cartIncrement(rowId) {
            $.ajax({
                type: 'GET',
                url: "/cart-increment/" + rowId,
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops... smth went wrong',
                            text: data.error
                        });

                    }
                    cart();
                    miniCart();
                }
            });
        }

        //cartDecrement
        function cartDecrement(rowId) {
            $.ajax({
                type: 'GET',
                url: "/cart-decrement/" + rowId,
                dataType: 'json',
                success: function(data) {
                    cart();
                    miniCart();
                }
            });
        }
    </script>

    <!-- Coupon Apply Start -->
    <script type="text/javascript">
        function applyCoupon() {
            var coupon_name = $('#coupon_name').val();
            //console.log(coupon_name);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "/coupon-apply/" + coupon_name,
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 2500
                        });
                        $('.apply-coupon').hide();
                        cart();
                        //miniCart();
                    }
                    if (data.error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                },
                failure: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... smth went wrong',
                        text: 'fail'
                    });
                }
            });

        }
    </script>

    <script type="text/javascript">
        function couponRemove() {
            $.ajax({
                type: 'GET',
                url: "{{ url('/coupon-remove') }}",
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 2500
                        });
                        $('#coupon_name').val('');
                        $('.apply-coupon').show();
                        cart();
                    }
                    // End Message 
                }
            });
        }
    </script>
    @yield('page_footer_scripts')
</body>

</html>