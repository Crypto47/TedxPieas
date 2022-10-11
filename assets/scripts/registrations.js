var TAG = '[main]';
var log = console.log;

$(function() {
    init_countdown();
    adjust_image();
    $(window).resize(function() {
        adjust_image();
    });

    $('.required').on('keyup', function() {
        if (this.value.length == 0) {
            $(this).parent().css('background', '#770000');
            $(this).parent().css('color', '#ffffff');
            $(this).next().show();
        } else {
            $(this).parent().css('background', '#333333');
            $(this).parent().css('color', '#ffffff');
            $(this).next().hide();
        }
    });

    $('#date_of_birth').on('change', function() {
        if (this.value.length == 0) {
            $(this).parent().css('background', '#770000');
            $(this).parent().css('color', '#ffffff');
            $(this).next().show();
        } else {
            $(this).parent().css('background', '#333333');
            $(this).parent().css('color', '#ffffff');
            $(this).next().hide();
        }
    });

    $('#registration-form').on('submit', function(e) {
        e.preventDefault();

        let d = new Date();
        let date_time = format(d.getFullYear()) + '-' + format(d.getMonth() + 1) + '-' + format(d.getDate()) + ' ' + format(d.getHours()) + ':' + format(d.getMinutes()) + ':' + format(d.getSeconds());
        let inputs = $('.question-input');
        let formData = new FormData();
        for (let i of inputs) {
            formData.append(i.name, i.value);
        }
        formData.append('gender', $('input[name=gender]:checked').val());
        formData.append('attended_before', $('input[name=attended_before]:checked').val());
        formData.append('heared_about_us', $('input[name=heared_about_us]:checked').val());
        formData.append('date_time', date_time);

        $.ajax({
            url: './assets/scripts/backend/WriteData.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#section-overlay').show();
                $('#section-overlay #button-exit').attr('disabled', true);
            },
            success: function(result) {
                log(result);
                result = JSON.parse(result);
                log('code -> ' + result.code);
                log(result.log);
                $('#section-overlay #button-exit').attr('disabled', false);
                if (result.code == 0) {
                    $('#section-overlay #overlay-title').html('You are successfully registered for TEDxPIEAS 2019.');
                    $('#section-overlay #button-exit').html('Done');
                    $('#section-overlay #overlay-image').attr('src', './assets/images/Form Submit Success.png');
                } else if (result.code == 1) {
                    $('#section-overlay #overlay-title').html('Someone already Registered using this CNIC.');
                    $('#section-overlay #button-exit').html('Try Again');
                    $('#section-overlay #overlay-image').attr('src', './assets/images/Form Submit Fail.png');
                } else {
                    $('#section-overlay #overlay-title').html('Error during registration, kindly try again.');
                    $('#section-overlay #button-exit').html('Try Again');
                    $('#section-overlay #overlay-image').attr('src', './assets/images/Form Submit Fail.png');
                }
            },
        });
    });

    $('#section-overlay #button-exit').click(function() {
        let button_text = $('#section-overlay #button-exit').html();
        log(button_text);
        if (button_text == 'Done') {
            window.location.reload();
        } else if (button_text == 'Try Again' || button_text == 'Back') {
            $('#section-overlay').hide();
        }
    });
});

function adjust_image() {
    let w1 = window.innerWidth;
    let threashold = Number.parseInt($('#theme-image').css('max-width'));
    let w2 = (w1 - threashold) / 2;
    if (w1 >= threashold) {
        $('#theme-image').css('left', w2);
    }
}

function format(x) {
    if (x < 10)
        return '0' + x;
    return x;
}

function init_countdown() {
    var countDownDate = new Date("Nov 3, 2019 11:59:00 PM").getTime();
    update_countdown(countDownDate);
    var x = setInterval(function() {
        update_countdown(countDownDate);
    }, 1000);
}

function update_countdown(countDownDate) {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    $("#countdown_days").html(format(days));
    $("#countdown_hours").html(format(hours));
    $("#countdown_minutes").html(format(minutes));
    $("#countdown_secs").html(format(seconds));

    if (distance < 0) {
        clearInterval(x);
    }
}