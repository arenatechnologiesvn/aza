<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <style>
        @page { size: 80mm 500mm } /* output size */
        /*body.receipt .sheet { width: 58mm; height: 100mm } !* sheet size *!*/
        @media print { body.page-wrap { width: 80mm } } /* fix for Chrome */

        /*
	 CSS-Tricks Example
	 by Chris Coyier
	 http://css-tricks.com
*/

        * { margin: 0; padding: 0; }
        body { font: 10px/1.4 Roboto, serif; }
        #page-wrap { width: 80mm; margin: 0 auto; }

        table { border-collapse: collapse; }
        table td, table th { border: 1px solid black; padding: 5px; }

        #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

        #address { width: 45%; height: 100px; float: left; }
        #customer { overflow: hidden; }

        #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 40mm; max-height: 100px; overflow: hidden; }
        #logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }
        #logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px; }
        #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
        #logohelp input { margin-bottom: 5px; }
        .edit #logohelp { display: block; }
        .edit #save-logo, .edit #cancel-logo { display: inline; }
        .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
        #customer-title { font-size: 13px; font-weight: bold; float: left; }

        #meta { margin-top: 1px; width: 55%; float: right; }
        #meta td { text-align: right;  }
        #meta td.meta-head { text-align: left; background: #eee; }
        #meta td textarea { width: 100%; height: 20px; text-align: right; }

        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th { background: #eee; }
        #items textarea { width: 80px; height: 50px; }
        #items tr.item-row td { border: 0; vertical-align: top; font-size: 10px; }
        #items td.item-name { width: 30mm; text-transform: uppercase; font-weight: bold;}
        #items td.description textarea, #items td.item-name textarea { width: 100%; }
        #items td.total-line { border-right: 0; text-align: right; }
        #items td.total-value { border-left: 0; padding: 10px; }
        #items td.total-value textarea { height: 20px; background: none; }
        #items td.balance { background: #eee; }
        #items td.blank { border: 0; }

        #terms { text-align: center; margin: 20px 0 0 0; }
        #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
        #terms textarea { width: 100%; text-align: center;}

        textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { background-color:#EEFF88; }
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

<div id="page-wrap">

    <div id="header">HÓA ĐƠN</div>

    <div id="identity">

            <div id="address">{{$settings['company']->address}}
                <br>
            Phone: {{$settings['company']->phone}}</div>

    </div>

    <div style="clear:both"></div>

    <div id="customer">
     <div>
         <table id="meta">
             <tr>
                 <td class="meta-head">Invoice #</td>
                 <td><div>000123</div></td>
             </tr>
             <tr>

                 <td class="meta-head">Date</td>
                 <td><div id="date">{{date("Y-m-d")}}</div></td>
             </tr>
             <tr>
                 <td class="meta-head">Tổng tiền</td>
                 <td><div class="due">{{number_format($order['total_money'])}}₫</div></td>
             </tr>

         </table>
     </div>
    <div class="customer-info">
        <ul class="customer-info--list">
            <li class="item"><strong>CỬA HÀNG: </strong><span> {{$order['shop']['name']}}</span></li>
            <li class="item"><strong>ĐỊA CHỈ: </strong><span> {{$order['delivery_address']}}</span></li>
            <li class="item"><strong>ĐIỆN THOẠI: </strong><span> {{$order['shop']['phone']}}</span></li>
            <li class="item"><strong>CHỦ CỬA HÀNG: </strong><span> {{$order['customer']['user']['full_name']}}</span></li>
            <li class="item"><strong>GIỜ GIAO HÀNG: </strong><span> {{$order['delivery_type']}}</span></li>
        </ul>
    </div>

    </div>

    <table id="items">

        <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
        @foreach($order['products'] as $index => $product)
            <tr class="item-row">
                <td>{{$index + 1}}</td>
                <td class="item-name"><div class="delete-wpr"><div>{{$product['name']}}</div></div></td>
                <td class="price">{{number_format($product['price'], 2)}}₫</td>
                <td class="qty">{{$product['pivot']['quantity']}}</td>
                <td class="cost">{{number_format($product['price'] * $product['pivot']['quantity'], 2)}}₫</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" class="blank"> </td>
            <td colspan="2" class="total-line">TỔNG TIỀN</td>
            <td class="total-value"><div id="subtotal">{{number_format($order['total_money'])}}₫</div></td>
        </tr>
    </table>

    <div id="terms">
        <h5>Terms</h5>
    </div>

</div>

</body>

</html>