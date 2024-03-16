<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Project Akhir Middle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Allison&display=swap" rel="stylesheet">
    <style>
      :root {
          --theme1-color: #911F27;
          --theme2-color: #630A10;
          --theme3-color: #FCF0C8;
          --theme4-color: #FACE7F;
      }

      .text-theme2{
        color: var(--theme2-color);
      }
      .text-theme3{
        color: var(--theme3-color);
      }

      .bg-theme1{
        background-color: var(--theme1-color);
      }
      .bg-theme2{
        background-color: var(--theme2-color);
      }
      .bg-theme3{
        background-color: var(--theme3-color);
      }
      .bg-theme4{
        background-color: var(--theme4-color);
      }

      .font-allison{
        font-family:Allison;
      }
  </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">

  @can('admin')
  <x-web.admin.header/>
  {{$slot}}
  <x-web.admin.footer/>
      
  @elsecan('staff')
  <x-web.staff.header/>
  {{$slot}}
  <x-web.staff.footer/>

  @else
  {{$slot}}

  @endcan

      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
      var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
      })
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
  </script>
  </body>
  </html>