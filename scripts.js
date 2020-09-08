$(document).ready(function() {
	$('.modal').modal();
});

function teaser(text) {
	return text.length <= 50 ? text : text.substr(0, 50) + "...";
}

var share;

function init(joke, jokeId) {
	share = {
		text: teaser(joke),
		icon: 'grin-squint',
		send: function () {
			apretaste.send({
				command: 'PIZARRA PUBLICAR',
				redirect: false,
				callback: {
					name: 'toast',
					data: 'Tu chiste fue compartido'
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