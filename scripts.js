$(document).ready(function() {
    $('.tabs').tabs();
    $('.modal').modal();
    $('select').formSelect();
    $('.sidenav').sidenav();
});

function share(){
    apretaste.send({command:'PIZARRA PUBLICAR', data:{
            text: $('#message').val(),
            image: '',
            redirect: false,
            callback: {
                name: 'toast',
                data: 'Tu chiste compartido en Pizarra'
            },
            link: {
                command: btoa(JSON.stringify({
                    command: 'CHISTE VER',
                    data: {
                        id: jokeId
                    }
                })),
                icon: 'mood',
                text: joke.substr(0, 100)
            }
        }});
}

function toast(message){
    M.toast({html: message});
}