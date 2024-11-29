<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Гостевая книга</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Гостевая книга</h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-database-add"></i> Оставить сообщение
                    </button>
                </div>
                <div class="card-body">
                    <table id="messageTable" class="display">
                        <thead>
                        <tr>
                            <th>Номер сообщения</th>
                            <th>Имя пользователя</th>
                            <th>Эл. почта</th>
                            <th>Текст сообщения</th>
                            <th>Дата добавления</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Оставить сообщение</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="message-form" method="post">

                            <div class="row">
                                <div class="col-lg">
                                    <label>Имя пользователя</label>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                                <div class="col-lg">
                                    <label>Эл. почта</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg">
                                    <label>Ваше сообщение</label>
                                    <input type="text" name="textOfMessage" id="textOfMessage" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary" form="message-form">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        var table = $('#messageTable').DataTable({
            "ajax": {
                "url": "{{ route('getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    if (response.status === 200) {
                        return response.messages;
                    } else {
                        return [];
                    }
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "username" },
                { "data": "email" },
                { "data": "textOfMessage" },
                { "data": "created_at" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="'+data.id+'">Удалить</a>';
                    }
                }
            ]
        });

        $('#message-form').submit(function (e) {
            e.preventDefault();
            const messagedata = new FormData(this);
            $.ajax({
                url: '{{ route('store') }}',
                method: 'post',
                data: messagedata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 200) {
                        alert("Saved successfully");
                        $('#message-form')[0].reset();
                        $('#exampleModal').modal('hide');
                        $('#messageTable').DataTable().ajax.reload();
                    }
                }
            });
        });
    });

    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this employee?')) {
            $.ajax({
                url: '{{ route('delete') }}',
                type: 'DELETE',
                data: {id: id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response); // Debugging: log the response
                    if (response.status === 200) {
                        alert(response.message); // Show success message
                        $('#messageTable').DataTable().ajax.reload(); // Reload the table data
                    } else {
                        alert(response.message); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr); // Debugging: log the error
                    alert('Error: ' + error); // Show generic error message
                }
            });
        }
    });
</script>
</body>
</html>
