<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance QR Generator</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #0d1b2a;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 10px;
    }

    .card {
      background: #014421;
      padding: 40px 30px;
      border-radius: 18px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 420px;
      text-align: center;
      color: white;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 1.6rem;
    }

    input {
      width: 100%;
      padding: 14px;
      margin: 12px 0;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      box-sizing: border-box;
      outline: none;
    }

    button {
      width: 100%;
      padding: 14px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: bold;
      margin-top: 12px;
      transition: background 0.3s;
    }

    button:hover {
      background: #0056b3;
    }

    #qrcode {
      margin-top: 25px;
      display: flex;
      justify-content: center;
    }

    /* 🔹 Mobile Responsiveness */
    @media (max-width: 500px) {
      .card {
        padding: 30px 20px;
        border-radius: 14px;
      }
      h2 {
        font-size: 1.3rem;
      }
      input, button {
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Generate Attendance QR</h2>
    <input type="text" id="student_id" placeholder="Student ID">
    <input type="text" id="student_name" placeholder="Full Name">
    <button onclick="generateQR()">Generate QR</button>
    <div id="qrcode"></div>
  </div>

  <script>
    function generateQR() {
      const id = document.getElementById("student_id").value.trim();
      const name = document.getElementById("student_name").value.trim();
      const qrContainer = document.getElementById("qrcode");
      qrContainer.innerHTML = "";

      if (id && name) {
        const url = "http://192.168.1.87/digital-attendance-tracker/attendance.php"
                    + "?id=" + encodeURIComponent(id)
                    + "&name=" + encodeURIComponent(name);

        new QRCode(qrContainer, {
          text: url,
          width: 220,
          height: 220
        });
      } else {
        alert("⚠️ Please enter both Student ID and Full Name!");
      }
    }
  </script>
</body>
</html>
