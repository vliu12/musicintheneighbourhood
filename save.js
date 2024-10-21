const nodemailer = require('nodemailer');
const { google } = require('googleapis');
const express = require('express');
const bodyParser = require('body-parser');

const CLIENT_ID = '275501893419-f1tpsruf1m4dhetue7q6gpqngfjne5sk.apps.googleusercontent.com';
const CLIENT_SECRET = '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';
const REDIRECT_URI = 'https://developers.google.com/oauthplayground';
const REFRESH_TOKEN = '1//04tg5HRQDZl3ECgYIARAAGAQSNwF-L9IrS0hIssxJ_PrVoA2n0-CusD2QzqZwnuZKPdptq5taXSpo6X0wk_v0E11xbtBR4VOY5Do';

const oAuth2Client = new google.auth.OAuth2(CLIENT_ID, CLIENT_SECRET, REDIRECT_URI);
oAuth2Client.setCredentials({ refresh_token: REFRESH_TOKEN });

const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(__dirname)); // Serve static files from the root directory

app.post('/send-email', async (req, res) => {
  const { name, email, message } = req.body;

async function sendMail() {
  try {
    const accessToken = await oAuth2Client.getAccessToken();

    const transport = nodemailer.createTransport({
      service: 'gmail',
      auth: {
        type: 'OAuth2',
        user: 'musicintheneighbourhood@gmail.com',
        clientId: CLIENT_ID,
        clientSecret: CLIENT_SECRET,
        refreshToken: REFRESH_TOKEN,
        accessToken: accessToken.token, // Ensure you use .token
      },
    });

    const mailOptions = {
      from: 'Music in the Neighbourhood <musicintheneighbourhood@gmail.com>',
      to: email,
      subject: 'Hello from Music in the Neighbourhood!',
      text: 'Hey ${name} Thanks for reaching out. If you have questions about becoming a performer, volunteering, or organizing a concert in your own neighbourhood, please do not hesitate to email us at musicintheneighbourhood@gmail.com.',
    };

    // Await the sendMail method
    const result = await transport.sendMail(mailOptions);
    return result;

  } catch (error) {
    console.error('Error sending email:', error);
    throw error; // Throw the error to handle it in the calling context
  }
}

sendMail() 
  .then(result => console.log('Email sent...', result))
  .catch(error => console.log('Failed to send email:', error.message))});
