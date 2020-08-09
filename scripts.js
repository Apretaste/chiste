$(document).ready(function() {
    $('.tabs').tabs();
    $('.modal').modal();
    $('select').formSelect();
    $('.sidenav').sidenav();
});

function share(){
    apretaste.send({
        command:'PIZARRA PUBLICAR',
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
                icon: 'grin-squint',
                text: joke.substr(0, 100)
            }
        }});
}

function toast(message){
    M.toast({html: message});
}