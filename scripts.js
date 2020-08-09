$(document).ready(function() {
    $('.tabs').tabs();
    $('.modal').modal();
    $('select').formSelect();
    $('.sidenav').sidenav();
});

var share;

function init(joke, jokeId) {
    share = {
        text: joke.substr(0, 100),
        icon: 'grin-squint',
        send: function () {
            apretaste.send({
                command: 'PIZARRA PUBLICAR',
                redirect: false,
                callback: {
                    name: 'toast',
                    data: 'Tu chiste fue compartido en Pizarra'
                },
                data: {
                    text: $('#message').val(),
                    image: '',
                    link: {
                        command: btoa(JSON.stringify({
                            command: 'CHISTE VER',
                            data: {
                                id: jokeId
                            }
                        })),
                        icon: share.icon,
                        text: share.text
                    }
                }
            })
        }
    };
}

function toast(message){
    M.toast({html: message});
}