const articlesPerPage = 5; // количество статей на страницу
let currentPage = 1; // текущая страница
let totalPages = 1; // общее количество страниц

$(function () {
    refreshArticles();

    // при клике на кнопку "Обновить" запускаем функцию обновления статей
    $("#refresh-btn").click(function () {
        refreshArticles();
    });

    // при клике на "Полный текст" получаем полный текст статьи и отображаем в модальном окне на весь экран
    $(document).on("click", ".full-text-btn", function () {
        let articleId = $(this).data("article-id");
        $.ajax({
            url: "get_article.php",
            method: "POST",
            data: { id: articleId },
            dataType: "html",
            success: function (response) {
                $("#full-text-modal .modal-body").html(response);
                $("#full-text-modal").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: "error",
                    title: "Ошибка",
                    text: "Не удалось загрузить полный текст статьи"
                });
            }
        });
    });

    // при клике на номер страницы запускаем функцию отображения статей на выбранной странице
    $(document).on("click", ".pagination-link", function () {
        let pageNum = +$(this).text();
        if (pageNum >= 1 && pageNum <= totalPages) {
            currentPage = pageNum;
            showArticles();
        }
    });
});

function refreshArticles() {
    $.ajax({
        url: "parse_articles.php",
        method: "POST",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Успех",
                    text: "Статьи успешно загружены"
                });
                currentPage = 1;
                showArticles();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Ошибка",
                    text: "Не удалось загрузить статьи"
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: "error",
                title: "Ошибка",
                text: "Не удалось загрузить статьи"
            });
        }
    });
}

function showArticles() {
    $.ajax({
        url: "get_articles.php",
        method: "POST",
        data: {
            offset: articlesPerPage * (currentPage - 1),
            limit: articlesPerPage
        },
        dataType: "html",
        success: function (response) {
            $("#article-list").html(response);
            totalPages = Math.ceil($("#total-articles").val() / articlesPerPage);
            if (totalPages > 1) {
                showPagination();
            } else {
                $(".pagination").html("");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: "error",
                title: "Ошибка",
                text: "Не удалось загрузить список статей"
            });
        }
    });
}

function showPagination() {
    let paginationHtml = "";
    if (totalPages > 1) {
        if (currentPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" tabindex="-1">«</a></li>';
        }
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#">' + i + '</a></li>';
        }
        if (currentPage < totalPages) {
            paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#">»</a></li>';
        }
    }
    $(".pagination").html(paginationHtml);
    $(".pagination-link").removeClass("active");
    $(".pagination-link").eq(currentPage - 1).addClass("active");
}
