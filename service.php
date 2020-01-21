<?php

use Apretaste\Challenges;
use Framework\Database;
use Apretaste\Request;
use Apretaste\Response;

class Service
{
	/**
	 * Function executed when the service is called
	 *
	 * @param Request $request
	 * @param Response $response
	 */
	public function _main(Request $request, Response &$response)
	{
		// get random joke from the database
		$j = Database::query("SELECT * FROM _chiste ORDER BY RAND() LIMIT 1");

		// complete challenge
		Challenges::complete('view-chiste', $request->person->id);

		// create response content
		$content = [
			'joke' => $j[0]->text,
			'tags' => [$j[0]->cat1, $j[0]->cat2, $j[0]->cat3]
		];

		// send information to the view
		$response->setTemplate("basic.ejs", $content);
	}
}