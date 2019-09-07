<?php

require_once __DIR__.'/vendor/autoload.php';

class ChisteService extends ApretasteService
{

    /**
     * Function executed when the service is called
     *
     * @param Request
     */
    public function _main()
    {
        $url = "http://feeds.feedburner.com/ChistesD4w?format=xml";
        $rss = Feed::load($url);

        $jokes = [];

        foreach ($rss->item as $item) {
            $j = (string)$item->description;
            if (strpos($j, '<') === 0) {
                continue;
            }
            $j = html_entity_decode($j);
            $p = strpos($j, '<a ');
            if ($p !== false) {
                $j = substr($j, 0, $p);
            }
            $j = preg_replace("/\s+/", " ", $j);
            $j = str_replace(' / ', "\n", $j);
            $j = str_replace("<br /> <br /><br />", "", $j);
            $j = str_replace("<br /><br />", "", $j);
            $j = trim($j);
            if (empty($j)) {
                continue;
            }

            $jokes[] = [
                'description' => nl2br(strip_tags($j)),
                'author'      => (string)$item->author
            ];
        }
        // get a random joke, if no joke was found, use a default joke
        $defaultJoke = [
            'description' => "El rey hace un pase de visita a los soldados de guardia y al primero le pregunta: <br/>- A ver ¿por que un soldado de la guardia real tiene que cumplir su tarea ante cualquier circunstancia?! <br/>Y el soldado le responde: <br/> - Si chico, a ver porque eh?! porque eh?!",
            'author'      => 'El chiste de siempre'
        ];

        $j = empty($jokes) ? $defaultJoke : $jokes[mt_rand(0, count($jokes) - 1)];

        // create response
        $this->response->setLayout('chiste.ejs');
        $this->response->setTemplate("basic.ejs", ["joke" => $j]);

    }

    /**
     * Get remote content
     *
     * @param       $url
     * @param array $info
     *
     * @return mixed
     */
    private function getUrl($url, &$info = [])
    {
        $url = str_replace("//", "/", $url);
        $url = str_replace("http:/", "http://", $url);
        $url = str_replace("https:/", "https://", $url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        $default_headers = [
            "Cache-Control" => "max-age=0",
            "Origin"        => "{$url}",
            "User-Agent"    => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36",
            "Content-Type"  => "application/x-www-form-urlencoded"
        ];

        $hhs = [];
        foreach ($default_headers as $key => $val) {
            $hhs[] = "$key: $val";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $hhs);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $html = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info['http_code'] == 301) {
            if (isset($info['redirect_url']) && $info['redirect_url'] != $url) {
                return $this->getUrl($info['redirect_url'], $info);
            }
        }

        curl_close($ch);

        return $html;
    }
}
