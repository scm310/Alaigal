<style>
    /* Ensure the page takes at least the full height of the viewport */
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    /* Content container will push the footer down */
    .content {
      flex: 1;
    }

    /* Footer styles */
    .footer {
      background-color: #f8f9fa; /* Optional: add a background color */
      padding: 1rem 0;
      font-size: 12px;
      text-align: center;
    }

    .footer .text-black {
      color: black;
    }

    .footer .text-center {
      text-align: center;
    }
  </style>
</head>
<body>
  <footer class="footer">
    <div class="d-flex justify-content-center align-items-center flex-column flex-sm-row text-black">
      <span class="text-center mb-1 mb-sm-0">&copy; 2025. All rights reserved.</span>
      <span class="text-center ms-sm-3">Powered by Accelerated Development Machines Pvt. Ltd</span>
    </div>
  </footer>