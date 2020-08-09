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
	 * @throws \Framework\Alert
	 */
	public function _main(Request $request, Response &$response)
	{
		// get random joke from the database
		if (isset($request->input->data->id)) {
			$j = Database::queryFirst("SELECT * FROM _chiste id = {$request->input->data->id}");
		} else {
			$j = Database::queryFirst("SELECT * FROM _chiste ORDER BY RAND() LIMIT 1");
		}

		// complete challenge
		Challenges::complete('view-chiste', $request->person->id);

		// create response content
		$content = [
			'jokeId' => $j->id,
			'joke' => $j->text,
			'tags' => [$j->cat1, $j->cat2, $j->cat3]
		];

		// send information to the view
		$response->setTemplate("basic.ejs", $content);
	}

	/**
	 * View specific joke
	 *
	 * @param Request $request
	 * @param Response $response
	 * @throws FeedException
	 * @throws \Framework\Alert
	 */
	public function _ver(Request $request, Response &$response)
	{
		return $this->_main($request, $response);
	}
}
