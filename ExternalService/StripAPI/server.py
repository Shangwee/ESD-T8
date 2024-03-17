import os
from flask import Flask, redirect, request, jsonify
from flask_cors import CORS

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
    try:
        data = request.json
        invoice_id = data['invoice_id']
        total_price = data['total_price']

        checkout_session = stripe.checkout.Session.create(
            line_items=[
                {
                    'price_data': {
                        'currency': "SGD",
                        'unit_amount': int(total_price),
                        'product_data': {
                            'name': f'Invoice No. : {invoice_id}',
                        }
                    },
                    'quantity': 1
                },
            ],
            mode='payment',
            success_url=YOUR_DOMAIN + '/success.html',
            cancel_url=YOUR_DOMAIN + '/checkout.html',
        )

        # return jsonify({"code": 200, "message": 'successful payment'})

    except Exception as e:
        return str(e)
    
    return {'url': checkout_session.url, "code": 303}

    # return redirect(checkout_session.url, code=303)

if __name__ == '__main__':
    app.run(port=4242)