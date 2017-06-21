<?php

class Chiste extends Service {
	/**
	 * Function executed when the service is called
	 *
	 * @param Request
	 * @return Response
	 * */
	public function _main(Request $request)
	{
		// get the latest jokes from the internet
		$page = @file_get_contents("http://feeds.feedburner.com/ChistesD4w?format=xml");

		// clean the jokes into an array
		$mark = '<description>';
		$jokes = array();
		$last_pos = 0;

		do
		{
			$p1 = strpos($page, $mark, $last_pos);
			if ($p1 !== false)
			{
				$p2 = strpos($page, '</description>', $p1);
				$joke = substr($page, $p1 + strlen($mark), $p2 - $p1 - strlen($mark));
				$j = $joke;				
				$j = html_entity_decode($j, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
				$p = strpos($j, '<br xml:base="');
				
				if ($p !== false) $j = substr($j, 0, $p);
				
				$p = strpos($j, '<a href="http://chistes.developers4web.com/');
				
				if ($p !== false) $j = substr($j, 0, $p);

				$j = str_replace("/ ", " ", $j);
				$j = nl2br($j);
				
				$joke = trim($j);
				
				$joke = wordwrap($joke, 200, "\n");
				
				if (strlen($joke) > 30)
					if (stripos($joke, ' the') == false)
						if (stripos($joke, 'the ') == false)
							$jokes[] = $joke;
				
				$last_pos = $p2;
			}
		} while ($p1 !== false);

		// get a random joke, if no joke was found, use a default joke
		$defaultJoke = "El rey hace un pase de visita a los soldados de guardia y al primero le pregunta: <br/>- A ver ¿por que un soldado de la guardia real tiene que cumplir su tarea ante cualquier circunstancia?! <br/>Y el soldado le responde: <br/> - Si chico, a ver porque eh?! porque eh?!";
		$j = empty($jokes) ? $defaultJoke : $jokes[mt_rand(0, count($jokes) - 1)];

		// clean the joke
		$j = preg_replace("/\s+/", " ", $j);
		$j = str_replace("<br /> <br /><br />", "", $j);
		$j = str_replace("<br /><br />", "", $j);

		// create response
		$response = new Response();
		$response->setResponseSubject("Un chiste, un chiste!");
		$response->createFromTemplate("basic.tpl", array("joke" => $j));

		return $response;
	}	
}
