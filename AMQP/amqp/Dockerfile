FROM rabbitmq:3-management
RUN python amqp_setup.py
RUN rabbitmq-plugins enable rabbitmq_web_stomp
COPY rabbitmq.conf /etc/rabbitmq/rabbitmq.conf