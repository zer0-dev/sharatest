var mode = false; //0 - login, 1 - register
function play(){
   	setTimeout(function(){
   		document.querySelector('#logo').setAttribute('style','animation:logoslide 0.5s;margin-left:unset;margin-right:unset;left:10;right:unset;top:0;width:100px;');
   		document.querySelector('#playBtn').remove();
   		var xhr = new XMLHttpRequest();
   		xhr.open('GET','/frame.php',false);
   		xhr.send();
   		if(xhr.status == 200){
   			document.querySelector('#container').innerHTML = xhr.responseText;
   			if(document.querySelector('#hidden') != null){
   				document.querySelector('#container').setAttribute('style','width:100%;height:90%;');
   				document.querySelector('#menu').setAttribute('style','display:block;animation:menuslide 1s;');
   			}
        document.querySelector('#mainBtn').addEventListener('click',function(){
          signup();
        });
        document.addEventListener('keyup',function(e){
          e.preventDefault();
          if(e.keyCode === 13){
            signup();
          }
        });
   			function signup(){
   				var xhr = new XMLHttpRequest();
   				xhr.open('GET','/api/signup.php?mode='+mode+'&login='+document.querySelector('#login').value+'&password='+document.querySelector('#password').value,false);
   				xhr.send();
   				if(xhr.status == 200){
   					var res = JSON.parse(xhr.responseText);
   					if(res.error.length == 0){
   						if(mode){
   							alert('Успешная регистрация');
   						 window.location.reload();
   						} else{
   							if(res.response == 'ok'){
   								var xhr = new XMLHttpRequest();
   								xhr.open('GET','/frame.php',false);
   								xhr.send();
   								if(xhr.status == 200){
   									document.querySelector('#container').innerHTML = xhr.responseText;
   									if(document.querySelector('#hidden') != null){
   				document.querySelector('#container').setAttribute('style','width:100%;height:90%;');
   				document.querySelector('#menu').setAttribute('style','display:block;animation:menuslide 1s;');
   			}
   								}
   							}
   						}
   					} else{
   						var e = '';
   						for(var i=0;i<res.error.length;i++){
   							e += res.error[i]+', ';
   						}
   						alert('Ошибка! '+e);
   					}
   				}
        }
   			document.querySelector('#secondBtn').addEventListener('click',function(){
   				if(mode){
   					document.querySelector('#mainBtn').setAttribute('style','animation:disap 1s;');
	document.querySelector('#mainBtn').innerHTML = 'Войти';
   				document.querySelector('#head').setAttribute('style','animation:disap 1s;');
	document.querySelector('#head').innerHTML = 'Играть';
	document.querySelector('#secondBtn').setAttribute('style','animation:disap 1s;');
	document.querySelector('#secondBtn').innerHTML = 'Регистрация';
	setTimeout(function(){
		document.querySelector('#head').setAttribute('style','animation:opac 1s;');
		document.querySelector('#mainBtn').setAttribute('style','animation:opac 1s;');
		document.querySelector('#secondBtn').setAttribute('style','animation:opac 1s;');
	})
   				}else{
   			document.querySelector('#mainBtn').setAttribute('style','animation:disap 1s;');
	document.querySelector('#mainBtn').innerHTML = 'Регистрация';
	document.querySelector('#secondBtn').setAttribute('style','animation:disap 1s;');
	document.querySelector('#secondBtn').innerHTML = 'Уже есть аккаунт?';
   				document.querySelector('#head').setAttribute('style','animation:disap 1s;');
	document.querySelector('#head').innerHTML = 'Регистрация';
	setTimeout(function(){
		document.querySelector('#head').setAttribute('style','animation:opac 1s;');
		document.querySelector('#mainBtn').setAttribute('style','animation:opac 1s;');
		document.querySelector('#secondBtn').setAttribute('style','animation:opac 1s;');
    document.addEventListener('keyup',function(e){
      e.preventDefault();
      if(e.keyCode === 13){
        signup();
      }
    });
	})
	}
	mode = !mode;
   			});
   			document.querySelector('#container').setAttribute('style','animation:opac 1s;opacity:1;');
   		}
   },500);
   	document.querySelector('#playBtn').setAttribute('style','animation:slide 0.5s;');
}

document.querySelector('#logout').addEventListener('click',function(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET','/api/logout.php',false);
	xhr.send();
	if(xhr.status == 200) window.location.reload();
});

document.querySelector('#settings').addEventListener('click',function(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET','/settings.php',false);
	xhr.send();
	if(xhr.status == 200){
		document.querySelector('.window').innerHTML = xhr.responseText;
		document.querySelector('#closeWin').addEventListener('click',function(){
			document.querySelector('.overlay').setAttribute('style','animation:disap 0.5s;display:none;');
	document.querySelector('#container').setAttribute('style','width:100%;height:90%;');
	document.querySelector('#menu').setAttribute('style','display:block;animation:menuslide 1s;');
	document.querySelector('#starter').setAttribute('style','');
		});
		document.querySelector('#saveSettings').addEventListener('click',function(){
			var level = document.querySelector('#level').value;
			var volume = document.querySelector('#volume').value;
			var weapon = document.querySelector('#weapon').value;
			var magic = document.querySelector('#magic').value;
			var sel = document.querySelector('#avatar');
			var avatar = sel.options[sel.selectedIndex].value;
			var xhr = new XMLHttpRequest();
			xhr.open('GET','/api/settings.php?level='+level+'&volume='+volume+'&weapon='+weapon+'&magic='+magic+'&avatar='+avatar,false);
			xhr.send();
			if(xhr.status == 200){
				var res = JSON.parse(xhr.responseText);
				if(res.response == 'ok'){
					document.querySelector('.overlay').setAttribute('style','animation:disap 0.5s;display:none;');
	document.querySelector('#container').setAttribute('style','width:100%;height:90%;');
	document.querySelector('#menu').setAttribute('style','display:block;animation:menuslide 1s;');
	document.querySelector('#starter').setAttribute('style','');
	var xhr = new XMLHttpRequest();
   								xhr.open('GET','/frame.php',false);
   								xhr.send();
   								if(xhr.status == 200){
   									document.querySelector('#container').innerHTML = xhr.responseText;
   									if(document.querySelector('#hidden') != null){
   				document.querySelector('#container').setAttribute('style','width:100%;height:90%;');
   				document.querySelector('#menu').setAttribute('style','display:block;animation:menuslide 1s;');
   			}
   	 }
				} else{
					var text = 'Ошибка: ';
					for(i=0;i<res.error.length;i++){
						text += res.error[i]+', ';
					}
					alert(text);
				}
			}
		});
	}
	document.querySelector('.overlay').setAttribute('style','animation:opac 0.5s;display:block;');
	document.querySelector('#container').setAttribute('style','width:100%;height:90%;filter:blur(5px);');
	document.querySelector('#menu').setAttribute('style','display:block;animation:menuslide 1s;filter:blur(5px);');
	document.querySelector('#starter').setAttribute('style','filter:blur(5px);');
});

function removeVk(){
  var xhr = new XMLHttpRequest();
  xhr.open("GET","/api/removeVk.php");
  xhr.send();
  xhr.onreadystatechange = function(){
    window.location.reload();
  }
}
