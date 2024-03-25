import os
from flask import Flask, redirect, request, jsonify, json
from flask_cors import CORS
from urllib.parse import quote_plus

import stripe

stripe.api_key = 'sk_test_51OuE8dJeCu6WnMKG0SSJZY7S7GL9b1RzXDLF12IU6yFKzUzNcvxijAF4mPeBlpHiOS6AFqHKKCb9c2PPr4ogudgH007zw5ypTx'

app = Flask(__name__,
            static_url_path='',
            static_folder='public')

CORS(app)

YOUR_DOMAIN = 'http://localhost:4242'

@app.route('/test')
def test():
    return 'hello world'


@app.route('/create-checkout-session', methods=['POST'])
def create_checkout_session():
    print("it is coming inDO?")
    try:
        if request.is_json:
            data = request.get_json()
            print(data)
            invoice_id = data['invoice_id']
            total_price = data['total_price']
            print(invoice_id)
            print(total_price)

            # process_data = json.loads(data)

            # print("Data received: ", data)
            # print("-------------")

            json_str = json.dumps(data)
            encoded_json_str = quote_plus(json_str)


            checkout_session = stripe.checkout.Session.create(
                line_items=[
                    {
                        'price_data': {
                            'currency': "SGD",
                            'unit_amount': int(total_price),
                            'product_data': {
                                'name': f'Invoice No. : {int(invoice_id)}',
                            }
                        },
                        'quantity': 1
                    },
                ],
                mode='payment',

                success_url=f'http://localhost:8080/ESD/ESD-T8/UI/views/success.php?status={encoded_json_str}'
                # success_url=f'http://localhost:4242/success.php?status={encoded_json_str}'
                # success_url=f'http://localhost:4242/checkout.html?status={encoded_json_str}'
                # success_url=YOUR_DOMAIN + '/success.html',
                # cancel_url=YOUR_DOMAIN + '/checkout.html',
            )

            # change back to JSON
            # print("CHECK JSON")
            # print(checkout_session.url)

            # return jsonify({
            #     "code": 303,
            #     "url": checkout_session.url
            # })


        else:
            print("this is not working")

        # return jsonify({"code": 200, "message": 'successful payment'})

    except Exception as e:
        return str(e)
    

    return {'url': checkout_session.url, "code": 303}

    # return redirect(checkout_session.url, code=303)

if __name__ == '__main__':
    app.run(port=4242, debug=True)