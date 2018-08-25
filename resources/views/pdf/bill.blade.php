<html>
    <head>
        <style>
            @media print and (width: 21cm) and (height: 29.7cm) {
                @page {
                    margin: 3cm;
                }
            }

            /* style sheet for "letter" printing */
            @media print and (width: 8.5in) and (height: 11in) {
                @page {
                    margin: 1in;
                }
            }

            /* A4 Landscape*/
            @page {
                size: A4 landscape;
                margin: 10%;
            }
            h2 {
                text-align: center;
                text-transform: uppercase;
                font-size: 20px;
            }
            table {
                width: 100%;
                margin-top: 20px;
            }
            table, th, tr, td {
                border: 1px solid #d6d6d6;
            }
            td, th {
                padding: 10px;
            }
            .item {
                padding: 10px 0;
            }
            strong {
                margin-right: 15px;
            }
            .company {
                position: fixed;
                bottom: 10px;
                left: 20px;
            }
        </style>
    </head>
    <body>
        <h2>{{$order['order_code']}}</h2>

        <div class="item"><strong>TÊN CỬA HÀNG: </strong><span> {{$order['shop']['name']}}</span></div>
        <div class="item"><strong>ĐỊA CHỈ NHẬN HÀNG: </strong><span> {{$order['delivery_address']}}</span></div>
        <div class="item"><strong>ĐIỆN THOẠI LIÊN HỆ: </strong><span> {{$order['delivery_address']}}</span></div>
        <div class="item"><strong>CHỦ CỬA HÀNG: </strong><span> {{$order['customer']['user']['full_name']}}</span></div>
        <div class="item"><strong>GIỜ GIAO HÀNG: </strong><span> {{$order['delivery_type']}}</span></div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>TÊN SẢN PHẨM</th>
                    <th>GIÁ SẢN PHẨM</th>
                    <th>ĐỊNH LƯỢNG</th>
                    <th>SỐ LƯỢNG</th>
                    <th>THÀNH TIỀN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order['products'] as $index => $product)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$product['name']}}</td>
                        <td>{{number_format($product['price'], 2)}}</td>
                        <td>{{$product['quantitative']}}</td>
                        <td>{{$product['pivot']['quantity']}}</td>
                        <td>{{number_format($product['price'] * $product['pivot']['quantity'], 2)}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfooter>
                <tr>
                    <td colspan="6" style="text-align: right">
                        <strong>TỔNG TIỀN </strong>
                        <span>{{number_format($order['total_money'])}}</span>
                    </td>
                </tr>
            </tfooter>
        </table>
        <div class="company">Copyright © Công Ty Cổ Phần Thịnh Thế</div>
    </body>
</html>

