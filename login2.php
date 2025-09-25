    <style>


    .login-card {
      
      box-shadow:
        0 10px 20px 0 #fff inset,
        0 20px 30px 0 #5fff9c inset,
        0 60px 60px 0 #211eec inset;
      border-radius: 1rem;
      padding: 2rem;

      width: 100%;
      max-width: 400px;
    }

    .login-card h1 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 1.5rem;
      background: linear-gradient(90deg, #1043ecff, #5fff9c, #211eec);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .form-control {
      
      border: none;

    }

    .form-control:focus {

      box-shadow: 0 0 10px #5fff9c;
    }

    .btn-login {
      background: linear-gradient(90deg, #5fff9c, #211eec);
      border: none;
      color: #ffffffff;
      font-weight: bold;
    }

    .btn-login:hover {
      opacity: 0.9;
    }
  </style>
  
  <div class="d-flex flex-column align-items-center min-vh-100 justify-content-center">
    <div class="d-flex flex-column align-items-center justify-content-center login-card shadow-lg ">
    <h1>Accedi</h1>
    <br>
    <form action="./loginEngine.php" method="POST" class="d-flex flex-column">
      <input type="text" class="form-control rounded p-2 mb-3" name="username" placeholder="Username" required>
      <input type="password" class="form-control rounded p-2 mb-3" name="pass" placeholder="Password" required>
      <input type="submit" class="btn btn-login rounded p-2" value="Accedi">
    </form>
  </div>
  </div>