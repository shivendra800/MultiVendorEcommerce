<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
     <table style="width:700px;">
    <tr><td>&nbsp;</td></tr><br></br>
    <tr><td><img src="{{ asset('front/images/main-logo/shivendralogo.png') }}"</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Hello {{ $name }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Your Order #{{ $order_id }} status Has Been Updated to {{ $order_status }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    @if(!empty($item_courier_name)&&!empty($item_tracking_number))
    <tr><td>Courier Name: {{ $item_courier_name }} and Tracking Number is {{ $item_tracking_number }}</td></tr>
    @endif
    <tr><td>&nbsp;</td></tr>
    <tr><td>Your Order Details Has Been Given Below:-</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>
        <table style="width:95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
            <tr  bgcolor="#f7f4f4">
                <td>Product Name</td>
                <td>Product Code</td>
                <td>Product Size</td>
                <td>Product Color</td>
                <td>Product Quantity</td>
                <td>Product Price</td>
            </tr>
            @foreach ($orderDetails['orders_products'] as $order )
            <tr  bgcolor="#cccccc">
                <td>{{ $order['product_name'] }}</td>
                <td>{{ $order['product_code'] }}</td>
                <td>{{ $order['product_size'] }}</td>
                <td>{{ $order['product_color'] }}</td>
                <td>{{ $order['product_qty'] }}</td>
                <td>{{ $order['product_price'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" align="right">Shipping Charges</td>
                <td>INR {{ $orderDetails['shipping_charges'] }}</td>
            </tr>
            <tr>
                <td colspan="5" align="right">Coupon Discount</td>
                <td>INR
                    @if($orderDetails['coupon_amount']>0)
                     {{ $orderDetails['coupon_amount'] }}
                     @else
                     0
                     @endif
                    </td>
            </tr>
            <tr>
                <td colspan="5" align="right">Grand Total</td>
                <td>INR {{ $orderDetails['grand_total'] }}</td>
            </tr>
        </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table>
                <tr><td><strong>Delivery Address::</strong></td></tr>
                <tr><td>{{ $orderDetails['name'] }}</td></tr>
                <tr><td>{{ $orderDetails['address'] }}</td></tr>
                <tr><td>{{ $orderDetails['city'] }}</td></tr>
                <tr><td>{{ $orderDetails['state'] }}</td></tr>
                <tr><td>{{ $orderDetails['country'] }}</td></tr>
                <tr><td>{{ $orderDetails['pincode'] }}</td></tr>
                <tr><td>{{ $orderDetails['mobile'] }}</td></tr>
            </table>
            </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>For Any Queries, You Can Contact US At <a href="mailto:donotdistubs@gmail.com">donotdistubs@gmail.com</a></td></tr><br></br>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Thanks & Regards,</td></tr><br></br>
    <tr><td>Shivendra Developer</td></tr>
</table>

</body>
</html>
