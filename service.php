<?php

use Apretaste\Challenges;
use Framework\Database;
use Apretaste\Request;
use Apretaste\Response;

class Service
{
	private $client;

	/**
	 * Function executed when the service is called
	 *
	 * @param \Request $request
	 * @param \Response $response
	 *
	 * @throws \Framework\Alert
	 */
	public function _main(Request $request, Response &$response)
	{
		$j = Database::query("select * from _chiste order by rand() limit 1", true, "utf8mb4");

		// create response
		$response->setLayout('chiste.ejs');
		$response->setTemplate("basic.ejs", ["joke" => [
			'description' => $j[0]->text,
			'author' => $j[0]->cat1 .', '.$j[0]->cat2.', '.$j[0]->cat3 ]
		]);

		Challenges::complete('view-chiste', $request->person->id);
	}
}
