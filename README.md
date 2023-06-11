<p align="center"><img src="public/backend/images/pexels-artem-beliaikin-1051747-logo.jpg" width="50">E-commerce</p>

<p align="center">
Market App based on Laravel
</p>

## About User Side

Application users fortify for authentication. It has 2 langueges to choose from: english and hebrew. What user can do:

- Sign in/up.<p align="left"><img src="public/images/ecommerce_images/login.png" width="150" height="100"></p>
- Add/remove products to wishlist.<p align="left"><img src="public/images/ecommerce_images/wishlist.png" width="300" height="100"></p>
- Add/remove products to chart.Choose/edit chosen products qty, color, size(according to product properties).Use coupon.<p align="left"><img src="public/images/ecommerce_images/add2chart.png" width="150" height="100"><span>&nbsp; &nbsp;</span><img src="public/images/ecommerce_images/myChart.png" width="300" height="100"><span>&nbsp; &nbsp;</span><img src="public/images/ecommerce_images/applied_coupon.png" width="300" height="100"></p>
- Choose languege(english/hebrew).
- Use stripe for payments.<p align="left"><img src="public/images/ecommerce_images/start_checkout.png" width="150" height="100"><span>&nbsp; &nbsp;</span><img src="public/images/ecommerce_images/stripe_checkout.png" width="300" height="100"></p>
- Retreview orders details.<p align="left"><img src="public/images/ecommerce_images/order_recieved_notification.png" width="150" height="100"><span>&nbsp; &nbsp;</span><img src="public/images/ecommerce_images/order_view.png" width="150" height="100"></p>
- Update profile.<p align="left"><img src="public/images/ecommerce_images/user_profile.png" width="150" height="100"><span>&nbsp; &nbsp;</span><img src="public/images/ecommerce_images/user_dashboard.png" width="150" height="100"></p>
- Get in touch with support.<p align="left"><img src="public/images/ecommerce_images/support.png" width="150" height="100"></p>



## Layout

### Header

<p align="center">
<img src="public/images/ecommerce_images/header.png" width="400" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/hebrew_header.png" width="400" height="100">
</p>

### Footer

<p align="center">
<img src="public/images/ecommerce_images/footer.png" width="400" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/hebrew_footer.png" width="400" height="100">
</p>

### Single Product

<p align="center">
<img src="public/images/ecommerce_images/single_product.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/hebrew_single.png" width="150" height="100">
</p>


### Slider

<p align="center">
<img src="public/images/ecommerce_images/slider.png" width="150" height="100"><span>
</p>




## About Admin Side

> Admin has it's own login and protected by Fortify.
>
>>Using multi authentication.
>
> Admin control Brands, Categories, Sub-Categories, Sub-Sub-Categories, Products, Slider, Coupons, Discounts, Shipping.
>
>> Using ajax and livewire not to reload page.
>> For UI using fa-fa icons and google icons.
>> Editing or adding new product with multi image upload and preview before uploading.

<p align="center">
<img src="public/images/ecommerce_images/all_brands.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/all_categories.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/all_coupons.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/all_orders.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/all_products.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/edit_sub_sub.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/new_coupon.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/new_product.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/new_slider_item.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/slider_info.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/new_sub_sub_category.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/sub_category.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/shipping_devisions.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/shipping_districts.png" width="150" height="100">&nbsp; &nbsp;
<img src="public/images/ecommerce_images/shipping_states.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/sub_category.png" width="150" height="100">&nbsp; &nbsp;
</p>



## Admin Controls

> Admin has different dashboard and profile managing
>
>> Using charts to retreview products in stock, no option to sign up, added via seeder.
>> Side nav to make it more friendly

<p align="center">
<img src="public/images/ecommerce_images/admin_dashboard.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
<img src="public/images/ecommerce_images/admin_profile.png" width="150" height="100"><span>&nbsp; &nbsp;</span>
</p>




## Future updates

- Elastic Search
- Upgrade to php 8 and Laravel10
- Tracking Order
- Api for bulk uploading products
- Scheduled Command for notifications
- Cancel order and refund purchase
- Change theme dark/light as default


