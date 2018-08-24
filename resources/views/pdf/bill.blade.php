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
            }

        </style>
    </head>
    <body>
        <h2>{{$order['order_code']}}</h2>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order['products'] as $product)
                    <tr>
                        <td>
                            <img src="http://localhost:8000{{$product['featured'][0]['url']}}" height="100" width="100" alt="">
                        </td>
                        <td>{{$product['featured'][0]['url']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>

