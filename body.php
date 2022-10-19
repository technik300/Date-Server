<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>JSON server</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=5.0, user-scalable=yes">
		<link rel="stylesheet" type="text/css" href="style.css">
		<style></style>
   </head>
	<body>
		<header>		
		</header>
		<main>
			<form method="get" id="test">
			   <input class="test-date" type="date" name="date" id="date" value="" onchange="formatDate(this.value)"/>
				<output id="result" value=""></output>
			</form>
			<button class="btn get" type="button" onclick="submitForm('get_get')" >GET GET</button>
			<button class="btn set" type="button" onclick="submitForm('set_get')" >SET GET</button>			
			<button class="btn get1" type="button" onclick="submitForm('get_post')" >GET POST</button>
			<button class="btn set1" type="button" onclick="submitForm('set_post')" >SET POST</button>
		<input type="checkbox" id="help" name="help" class="hidden"/>	
			<div class="help">				
				<?php include('help.php');?>
			</div>
			<label class="help-button" for="help"></label>
			<div class="modal">
				<div class="ststus">Server Started!</div>
				<div class="date"><?php echo $today;?></div>
			</div>
			<div class="overlay" onclick="document.querySelector('#help').checked=false;"></div>	
		</main>
		<script>
			document.querySelector('#test').addEventListener('submit', function(event){
				event.preventDefault;
			});
			function formatDate(d){
				document.querySelector('#result').value = d.split('-').reverse().join('-');
			}
			async function submitForm(type){
				if(type == 'get_get' ){
					document.querySelector('.test-date').value = '';
					document.querySelector('#result').value = '';
					let response = await fetch('/index.php?date=', { method: 'GET'});
					document.querySelector('#result').value = await response.text();
					document.querySelector('.test-date').value = document.querySelector('#result').value.split('-').reverse().join('-');

				}else if(type == 'set_get'){
					if(document.querySelector('#result').value != ''){
						let response = await fetch('/index.php?date='+document.querySelector('#result').value, { method: 'GET'});
						let result = await response.text();
					}				
				}else if(type == 'get_post'){
					document.querySelector('.test-date').value = '';
					document.querySelector('#result').value = '';
					let response = await fetch('/index.php',{ 
						method: 'POST', 
						body: new FormData(document.querySelector('#test'))
					})
  						.then((response) => {

    						return response.text();
  						})
  						.then((data) => {
							 document.querySelector('#result').value = data;
							 document.querySelector('.test-date').value = document.querySelector('#result').value.split('-').reverse().join('-');
  					});

				}else if(type == 'set_post'){
					if(document.querySelector('#result').value != ''){
						let response = await fetch('/index.php',{ 
						method: 'POST', 
						body: new FormData(document.querySelector('#test'))
					})
  						.then((response) => {

    						return response.text();
  						})
  						.then((data) => {
							console.log(data);

  					});

					}
				}		
			}

		</script>
   </body>
</html>
