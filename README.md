# Date-Server
Request &amp; save new date

адрес локального сервера:

http://localhost:3000/

-------------------------------------------------------------

получить дату:

GET запрос http://localhost:3000/index.php?date=

-------------------------------------------------------------

установить дату:

GET запрос  http://localhost:3000/index.php?date=01-01-2022

-------------------------------------------------------------

если переменная $_GET пустая( http://localhost:3000 ) - сервер вернет эту страницу

-------------------------------------------------------------

если тип запроса не GET (POST, PUT и пр.) - ничего не вернет

-------------------------------------------------------------

при первом запуске в корневой папке будет создан файл timеstamp.txt с текущей датой,
в нем будет храниться и перезаписываться дата

-------------------------------------------------------------

из HTML запрос делается через форму c method="get"

-------------------------------------------------------------

из JS можно через форму или запрос XHR или fetch()

-------------------------------------------------------------

если предаваемая дата не соответствует формату 01-01-2022 (ноль впереди обязателен) - сервер вернет ошибку 'request error'

-------------------------------------------------------------

если значения даты или месяца выходят за рамки - сервер вернет ошибку 'request error'

-------------------------------------------------------------

если год меньше текущего - сервер вернет ошибку 'request error'

-------------------------------------------------------------

содержимое папки можно разместить на хостинге и привязать домен,
тогда запрос будет вида: http://domain.com?date=

-------------------------------------------------------------

в левом верхнем углу проверочный функционал - можно установить дату и запросить установленную

-------------------------------------------------------------
пример функции JS для запросов:

			async function requestDate(type, time = ''){
      
				if(type == 'get' ){               
        
					let response = await fetch('/index.php?date=', { method: 'GET'});
					let result = await response.text();
					return result;
          
				}else if(type == 'set'){
        
					if(time != ''){
						let response = await fetch('/index.php?date=' + time, { method: 'GET'});
						let result = await response.text();
                                                return result;
					}else{
                                                return;
                                         }	
          
				}
			}


