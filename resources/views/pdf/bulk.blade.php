<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <style>
        @page { size: {{$settings['print']->width}}mm {{$settings['print']->height}}mm } /* output size */
        /*body.receipt .sheet { width: 58mm; height: 100mm } !* sheet size *!*/
        @media print {
            body.page-wrap { width: {{$settings['print']->width}}mm }
        } /* fix for Chrome */
        .break {
            page-break-after: always;
        }
        /*
	 CSS-Tricks Example
	 by Chris Coyier
	 http://css-tricks.com
*/

        * { margin: 0; padding: 0; }
        body { font: {{$settings['print']->fontSize}}px/1.4 Roboto, serif; }
        #page-wrap { width: 100%; margin: 0 0; }

        table { border-collapse: collapse; border: 1px solid #333; margin-top: 30px; width: 100%; }
        table th, table td { padding: 5px 2px }
        tr { border-bottom: 1px solid #333;}
        td {
            text-align: center;
        }
        #header {
            height: 15px;
            width: 100%;
            margin: 20px 0;
            background: #222;
            text-align: center;
            color: white;
            font: bold 10px Helvetica, Sans-Serif;
            padding: 8px 0px;
        }

        #customer { overflow: hidden; }

        #meta td { text-align: right;  }

        /*#items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }*/
        #items th { background: #eee; }
        #items tr.item-row td {vertical-align: top; font-size: {{$settings['print']->fontSize}}px; }
        #items td.item-name { font-weight: bold;}
        #items td.blank { border: 0; }
        #note {margin: 50px 0 0 0;width: 100%; text-align: center; font-style: italic;}

        .customer-info {
            display: block;
            clear: both;
        }
        .customer-info ul {
            list-style: none;
        }
        .customer-info ul li {
            border-bottom: 1px dotted #e6e6e6;
            padding: 7px 0;
        }
    </style>
</head>

<body>
@foreach ($orders as $order)
<div class="break">
    <div id="page-wrap">

        <div id="header">HÓA ĐƠN BÁN LẺ <br>
            <small style="font-size: 8px;">{{date('d-m-Y h:m:s')}}</small></div>

        <div style="clear:both"></div>

        <div id="customer">
            <div class="customer-info">
                <ul class="customer-info--list">
                    <li class="item"><strong>Khách hàng: </strong><span> {{$order['customer']['user']['full_name']}}</span></li>
                    <li class="item"><strong>Địa chỉ: </strong><span> {{$order['delivery_address']}}</span></li>
                    <li class="item"><strong>Điện thoại: </strong><span> {{$order['shop']['phone']}}</span></li>
                    <li class="item"><strong>Ngày giờ giao hàng: </strong><span> {{date('d-m-Y', $order['delivery'])}} ({{$order['delivery_type']}})</span></li>
                </ul>
            </div>
        </div>

        <table id="items">
            <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá <br /> (₫)</th>
                <th>Số lượng</th>
                <th>Định lượng</th>
                <th>Thành tiền <br/> (₫)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order['products'] as $product)
                <tr class="item-row">
                    <td class="item-name">{{$product['name']}}</td>
                    <td class="price">{{number_format($product['price'])}}</td>
                    <td class="qty">{{$product['pivot']['quantity']}}</td>
                    <td class="unit">{{$product['quantitative']}}({{$product['unit']}}) </td>
                    <td class="cost">{{number_format($product['price'] * $product['pivot']['quantity'])}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line">TỔNG TIỀN</td>
                <td class="total-value"><div id="subtotal">{{number_format($order['total_money'])}}₫</div></td>
            </tr>
            </tbody>
        </table>

        <p id="note">
            <strong>Ghi chú: </strong> {{$settings['print']->note}}
        </p>

    </div>
</div>
@endforeach
</body>

</html>