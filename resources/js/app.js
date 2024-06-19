require('./bootstrap');

$(document).ready(function () {
    $('#emailForm').on('submit', function (e) {
        e.preventDefault();

        let email = $('#email').val();

        $('#message').text('loading...').removeClass('valid not-valid');
        axios.post('/validate-email', {
            email: email
        })
        .then(function (response) {
            if (response.data.nonvalid) {
                $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            } else {
                $('#message').text('valid').removeClass('not-valid').addClass('valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#transliteratorForm').on('submit', function (e) {
        e.preventDefault();

        let trtext = $('#tr_input').val();

        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/transliterate', {
            trtext: trtext
        })
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#combineArraysForm').on('submit', function (e) {
        e.preventDefault();
        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/combine-arrays', {})
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#foldersImageHandler').on('submit', function (e) {
        e.preventDefault();
        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/create-files', {})
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#createCsv').on('submit', function (e) {
        e.preventDefault();
        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/create-csv', {})
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#pageParser').on('submit', function (e) {
        e.preventDefault();
        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/parse-page', {})
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#fetchDb').on('submit', function (e) {
        e.preventDefault();
        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/fetchdb', {})
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });

    $('#handleDb').on('submit', function (e) {
        e.preventDefault();
        $('#message').text('loading...').removeClass('valid not-valid');

        axios.post('/handledb', {})
        .then(function (response) {
            if (response.data.message) {
                $('#message').text(response.data.message).removeClass('not-valid').addClass('valid');
            } else {
                $('#message').text('ERROR').removeClass('valid').addClass('not-valid');
            }
        })
        .catch(function (error) {
            $('#message').text('not valid').removeClass('valid').addClass('not-valid');
            console.error('Error:', error);
        });
    });
});