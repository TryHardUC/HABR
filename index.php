<!DOCTYPE html>
<html>

<head>
    <title>Список статей</title>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="container">
        <h1>Список статей</h1>
        <button type="button" class="btn btn-primary mb-2" id="refresh-btn">Обновить</button>
        <div id="article-list"></div>
        <ul class="pagination justify-content-center mt-3"></ul>
    </div>
    <div id="full-text-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Полный текст статьи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
</body>

</html>