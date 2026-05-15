console.log('movie.js loaded');

$(document).on('click', '#like-btn', function () {
    console.log('LIKE CLICK WORKS');

    let id = $(this).data('id');

    $.post(window.likeUrl, { id: id }, function (res) {

        if (res.error) return alert('Войдите в аккаунт');

        $('#like-count').text(res.likes);

        if (res.liked) {
            $('#like-btn').addClass('liked').text('❤️');
        } else {
            $('#like-btn').removeClass('liked').text('🤍');
        }
    });
});


// =====================
// ⭐ HOVER
// =====================
$(document).on('mouseenter', '.star', function () {
    let value = $(this).data('value');

    $('.rating-block .star').each(function () {
        $(this).toggleClass('hovered', $(this).data('value') <= value);
    });
});

$(document).on('mouseleave', '.rating-block', function () {
    $('.star').removeClass('hovered');
});


// =====================
// ⭐ ОЦЕНКА
// =====================
$(document).on('click', '.star', function () {

    let id = $(this).data('id');
    let starValue = $(this).data('value'); // 1–5
    let rating = starValue * 2; // 1–10 для БД

    $.post(window.rateUrl, { id: id, rating: rating }, function (res) {

        if (res.error) return alert('Войдите в аккаунт');

        $('#avg-rating').text(res.avg);

        // ⭐ ВАЖНО: используем starValue, а не rating
        $('.star').each(function () {
            $(this).toggleClass('active',
                $(this).data('value') <= starValue
            );
        });
    });
});


// =====================
// ❌ УДАЛИТЬ РЕЙТИНГ
// =====================
$(document).on('click', '#remove-rating', function () {

    let id = $(this).data('id');

    $.post(window.removeUrl, { id: id }, function (res) {

        if (res.error) return alert('Войдите в аккаунт');

        $('#avg-rating').text(res.avg);
        $('.star').removeClass('active');
    });
});


// =====================
// 💬 ОТЗЫВ
// =====================
$(document).on('click', '#send-review', function () {

    let id = $(this).data('id');
    let text = $('#review-text').val();
    let rating = $('.star.active').length;

    if (!rating) return alert('Поставьте оценку');
    if (!text.trim()) return alert('Введите текст');

    $.post(window.reviewUrl, {
        id: id,
        text: text,
        rating: rating
    }, function (res) {

        if (res.error) return alert('Войдите в аккаунт');

        console.log(res);

        $('#review-text').val('');

        let avatar = res.avatar ? res.avatar : 'default-avatar.png';

        $('#reviews-list').prepend(
            '<div class="review-item">' +

            '<img class="review-avatar" src="../uploads/' + (res.avatar ? res.avatar : 'default-avatar.png') + '">' +

            '<div class="review-body">' +

            '<div class="review-header">' +
            '<b>' + res.username + '</b>' +
            '<span class="review-date">' + res.created_at + '</span>' +
            '<span class="review-rating">⭐' + rating + '</span>' +
            '</div>' +

            '<div class="review-text">' + $('<div>').text(text).html() + '</div>' +

            '</div>' +

            '</div>'
        );
    });
});