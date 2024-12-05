<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
    <link href= "https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="row bg-dark m-0 align-items-center justify-content-center p-0 bg-gggrain" style="height: 100vh;">
    <div class="row align-items-center justify-content-center">
      <div class="col-md-4 bg-dark rounded border p-5 m-5 text-center text-dark">
        <h1 style="color: #FCC52D;"><img src="/favicon.ico" style="width:20%"></img><b>Hearts</b>OMSIPII</h1>
        <h3 class="mb-4" style="color: lightgrey;">
          Baza adopcyjna
        </h3>
        <a href="/admin/login">
          <button class="btn btn-warning p-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
              <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
            </svg>&nbsp;Przejdź do logowania
          </button>
        </a>
      </div>
    </div>
    <div class="row align-items-center justify-content-center">
      <div class="col-md-3 bg-danger  rounded p-2 m-2 text-center text-white">
        <h3>WERSJA ROZWOJOWA</h3>
      </div>
    </div>
  <script src=
      "https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js">
  </script>
<style>

  .bg-gggrain{
    background: no-repeat url({{asset('img/gggrain-11.svg')}});
    background-size: cover;
    backdrop-filter: blur(10px);
  }

</style>
</body>

</html>
