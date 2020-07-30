		var audio = document.getElementsByTagName("audio");
		//Останавливаем все треки
		for(let i = 0; i < audio.length; i++){
			audio[i].pause();
		}
		audio[0].play();
		for (let i = 0; i < audio.length; i++) {
			audio[i].addEventListener('ended', function() {
				if (audio[i].duration === audio[i].currentTime) {
					audio[i + 1].play();
				}
			});
		}