<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Accubits Machine Test</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </head>
    <body>

        <div class="jumbotron text-center">
            <h3>Accubits Machine Test</h3>
        </div>
          
        <div class="container">
            <div class="col-md-6">
                <form method="post" action="{{ route('uploadFile') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="filename">Upload CSV:</label>
                        <input type="file" class="form-control" id="filename" name="filename" required="">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>

    </body>
</html>
