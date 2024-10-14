document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way
  
    // Get the values from the form fields
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
  
    // Create a POST request to the backend
    fetch('/send-email', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ name, email, message })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Email sent successfully!');
        document.getElementById('contact-form').reset();
      } else {
        alert('Failed to send email. Please try again.');
      }
    })
    .catch(error => console.error('Error:', error));
  });
  