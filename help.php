<?php 
?>
			<p>адрес локального сервера:</p>
			<p><b>http://localhost:3000/</b></p>			
			<p>-------------------------------------------------------------</p>			
			<p>получить дату:</p>
			<p><b>GET запрос http://index.php?date=</b></p>
			<p>-------------------------------------------------------------</p>
			<p>установить дату:</p>
			<p><b>GET запрос index.php?date=01-01-2022</b></p>
			<p>-------------------------------------------------------------</p>
			<p>если переменная <b>$_GET</b> пустая<b>( http://localhost:3000 )</b> - сервер вернет эту страницу</p>			
			<p>-------------------------------------------------------------</p>			
			<p>если тип запроса не <b>GET (POST, PUT и пр.)</b> - ничего не вернет </p>			
			<p>-------------------------------------------------------------</p>
			<p>при первом запуске в корневой папке будет создан файл <b>timеstamp.txt</b> с текущей датой, <br/> в нем будет храниться и перезаписываться дата</p>					
			<p>-------------------------------------------------------------</p>
			<p>из <b>HTML</b> запрос делается через форму c  <b>method="get" </b></p>			
			<p>-------------------------------------------------------------</p>
			<p>из <b>JS</b> можно через форму или запрос <b>XHR</b> или <b>fetch()</b></p>
			<p>-------------------------------------------------------------</p>
			<p>если предаваемая дата не соответствует формату <b>01-01-2022 (ноль впереди обязателен)</b> - сервер вернет ошибку <b>'request error'</b></p>
			<p>-------------------------------------------------------------</p>
         <p>если значения даты или месяца выходят за рамки - сервер вернет ошибку <b>'request error'</b></p>
			<p>-------------------------------------------------------------</p>
         <p>если год меньше текущего  - сервер вернет ошибку <b>'request error'</b></p>
			<p>-------------------------------------------------------------</p>
			<p>содержимое папки можно разместить на хостинге и привязать домен, <br/> тогда запрос будет вида: <b>http://domain.com?date=</b></p>
			<p>-------------------------------------------------------------</p>
         <p>в левом верхнем углу проверочный функционал - можно установить дату и запросить установленную</p>
         <p>-------------------------------------------------------------</p>
