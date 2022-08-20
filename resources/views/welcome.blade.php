<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</head>
<body>
    <br><br>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-6">
                <form action="" id="envios">
                    <div class="mb-3">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required placeholder="Nombre">
                    </div>
                    <div class="mb-3">
                        <label for="">Correo</label>
                        <input type="text" class="form-control" name="correo" required placeholder="Correo">
                    </div>
                    <div class="mb-3">
                        <label for="">Telefono</label>
                        <input type="text" class="form-control" name="telefono" required placeholder="Telefono">
                    </div>
                    <div class="mb-3">
                        <label for="">Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" required placeholder="Ciudad">
                    </div>
                    <div class="mb-3">
                        <label for="">Estado</label>
                        <input type="text" class="form-control" name="estado" required placeholder="Estado">
                    </div>
                    <div class="mb-3">
                        <label for="">Municipio</label>
                        <input type="text" class="form-control" name="municipio" required placeholder="Municipio">
                    </div>
                    <div class="mb-3">
                        <label for="">CP</label>
                        <input type="text" class="form-control" name="cp" required placeholder="CP">
                    </div>
                    <div class="mb-3">
                        <label for="">Colonia</label>
                        <input type="text" class="form-control" name="colonia" required placeholder="Colonia">
                    </div>
                    <div class="mb-3">
                        <label for="">Calle</label>
                        <input type="text" class="form-control" name="calle" required placeholder="Calle">
                    </div>
                    <div class="mb-3">
                        <label for="">Número de casa</label>
                        <input type="text" class="form-control" name="numero" required placeholder="Número de casa">
                    </div>
                    <button type="button" class="btn btn-secondary">Registrar</button>
                    <button type="submit" class="btn btn-primary">Calcular envio</button>
                </form>
                
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Detalles de envio
                    </div>
                    <div class="card-body">
                        <iframe id="apiMapa" frameborder="0"></iframe>
                        <br>
                        <li>Costo de envio: $<b id="costo"></b></li>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $('#envios').submit(function(e){
            e.preventDefault();
            var envios = $(this).serialize();
            $.ajax({
                'data': envios,
                'url': 'googleCalcular',
                'type': 'post',
                success: function(response){
                    var envio_data = JSON.parse(response);
                    $('#apiMapa').prop('src', 'https://www.google.com/maps/embed/v1/directions?key=AIzaSyB4CbJQ4DyUU8PBQA9wtm9IqClbF7dhOuo&origin='+envio_data.coordenadasUTS+'&destination='+envio_data.coordenadasDestino+'&mode=driving');
                    $('#costo').html(envio_data.envio);
                }
            })
        })
    </script>
    <br>
<br>
<br>
<footer>
<center>
<a href="/privacidad">Políticas de privacidad </a>
</footer>
</center>
</body>

</html>