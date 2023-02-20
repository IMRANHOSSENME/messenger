from flask import Flask, request
from pymessenger.bot import Bot

app = Flask(__name__)

PAGE_ACCESS_TOKEN = "EAAMg1bZB1a1UBAJ8kkmPNybVNxCk5qf6tMAsHiJ9P2KCMmqe0xvs8QWmJXP7FcbTXi8yHNZAfZALmbr48ijBpwAcfqWmQec96dIsNqYl8nmsMDZAkRn2u8yRsWjmkmMm1d87zyv0QfO74QhhQKUXvG9JENneZB0sSqZAGilMyGYLUbJaAd5zS4E6PfeiZAWR02ZBuPhjCzMdQQZDZD"
VERIFY_TOKEN = "ksjsjksoacabaoisvskaisnaiagavanha"

bot = Bot(PAGE_ACCESS_TOKEN)

@app.route('/', methods=['GET', 'POST'])
def receive_message():
    if request.method == 'GET':
        # handle the webhook verification
        token_sent = request.args.get("hub.verify_token")
        return verify_fb_token(token_sent)
    else:
        # handle the incoming messages
        output = request.get_json()
        for event in output['entry']:
            messaging = event['messaging']
            for message in messaging:
                if message.get('message'):
                    recipient_id = message['sender']['id']
                    if message['message'].get('text'):
                        response_sent_text = get_message_response(message['message']['text'])
                        send_message(recipient_id, response_sent_text)
                    if message['message'].get('attachments'):
                        response_sent_nontext = get_message_response("attachment")
                        send_message(recipient_id, response_sent_nontext)
    return "Message Processed"
def verify_fb_token(token_sent):
    if token_sent == VERIFY_TOKEN:
        return request.args.get("hub.challenge")
    else:
        return 'Invalid verification token'
def get_message_response(message):
    response = "I'm sorry, I didn't understand that."
    if message.lower() == "hello":
        response = "Hello! How can I help you today?"
    elif message.lower() == "what is your name?":
        response = "My name is Chatbot."
    return response
def send_message(recipient_id, response):
    bot.send_text_message(recipient_id, response)
    return "success"
if __name__ == "__main__":
    app.run()
