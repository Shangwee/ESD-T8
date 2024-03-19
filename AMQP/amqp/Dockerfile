FROM python:3-slim
WORKDIR /usr/src/app
COPY requirements.txt ./
RUN python -m pip install --no-cache-dir -r requirements.txt
RUN python amqp_setup.py
FROM rabbitmq:3-management
RUN rabbitmq-plugins enable rabbitmq_web_stomp
COPY rabbitmq.conf /etc/rabbitmq/rabbitmq.conf