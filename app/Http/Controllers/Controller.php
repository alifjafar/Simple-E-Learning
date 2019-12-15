<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ApiGET($path, $query = [])
    {
        $client = new Client(['http_errors' => false]);
        $uri = env('QUIZ_API_URL') . $path;
        $response = $client->get($uri, [
                'query' => $query,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . env('QUIZ_API_KEY')
                ]
            ]
        );
        $content = $response->getBody()->getContents();

        if ($response->getStatusCode() === 200) {
            return json_decode($content, true);
        } else if ($response->getStatusCode() === 422) {
            return abort($response->getStatusCode(), $content);
        } else if ($response->getStatusCode() === 401) {
            return abort(401, $content);
        } else {
            Session::flash('error','Something went wrong');

            return abort(301, '', ['Location' => request()->url()]);
        }
    }


    public function ApiPOST($path, $payload = [])
    {
        $client = new Client(['http_errors' => false]);
        $uri = env('QUIZ_API_URL') . $path;

        $response = $client->post($uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('QUIZ_API_KEY')
            ],
            'json' => $payload
        ]);

        return $response;
    }

    public function ApiPUT($path, $payload = [])
    {
        $client = new Client(['http_errors' => false]);
        $uri = env('QUIZ_API_URL') . $path;

        $response = $client->put($uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('QUIZ_API_KEY')
            ],
            'json' => $payload
        ]);

        return $response;
    }

}
