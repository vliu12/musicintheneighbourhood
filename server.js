const express = require('express');
const bodyParser = require('body-parser');
const nodemailer = require('nodemailer');
const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));

// Serve static files (HTML and CSS) from the root directory
app.use(express.static(__dirname)); // __dirname points to the current directory

// Route to send email
app.post('/send-email', (req, res) => {
  const { name, email, message } = req.body;

  // Create a transporter object
  const transporter = nodemailer.createTransport({
    service: 'gmail', // e.g. 'gmail', 'yahoo', etc.
    auth: {
      user: 'musicintheneighbourhood@gmail.com', // your email address
      pass: 'Delta2006!', // your email password or app password
    },
  });

  // Email options
  const mailOptions = {
    from: email,
    to: 'musicintheneighbourhood@gmail.com', // destination email address
    subject: `Message from ${name}`,
    text: message,
  };

  // Send the email
  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.log('Error: ', error);
      return res.status(500).send('Error sending email');
    }
    console.log('Email sent: ' + info.response);
    res.status(200).send('Email sent successfully');
  });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
