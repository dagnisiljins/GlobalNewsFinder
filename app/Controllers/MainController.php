<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;
use DateTime;
use App\Models\NewsCollection;
use App\Models\News;

class MainController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        $news = $this->api->fetchNews('', 'us', '', '');
        //dump($news); die;
        return new Response(
            'index',
            [
                'newsCollection' => $news
            ]
        );
    }

    public function search(): Response
    {
        $q = $_GET['q'] ?? '';
        $country = $_GET['country'] ?? '';
        $from = $_GET['from'] ?? null; //date formats YYYY-MM-DD
        $to = $_GET['to'] ?? null; //date formats YYYY-MM-DD


        if (!empty($from) && !empty($to)) {
            // Attempt to create DateTime objects from the input dates
            $fromDate = DateTime::createFromFormat('Y-m-d', $from);
            $toDate = DateTime::createFromFormat('Y-m-d', $to);

            if ($fromDate && $toDate) {
                // Dates are valid and in the correct format
                $from = $fromDate->format('Y-m-d'); // Format to YYYY-MM-DD
                $to = $toDate->format('Y-m-d'); // Format to YYYY-MM-DD
            } else {
                return new Response(
                    'error',
                    [
                        'error message' => 'Nepareizs datuma formats'// todo izveidot error twig
                    ]
                );
            }
        }

        $news = $this->api->fetchNews($q, $country, $from, $to);

        return new Response(
            'search',
            [
                'newsCollection' => $news
            ]
        );
    }

}