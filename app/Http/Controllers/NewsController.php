<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Jobs\SendNotification;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use InvalidArgumentException;
use RuntimeException;
use Telegram\Bot\Laravel\Facades\Telegram;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index(): View
    {
        $news = News::orderBy('date_added', 'DESC')->paginate(10);
        return view('welcome', ['news' => $news]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param $data 
     * @return News
     */
    public function store($data): News
    {
        $news = News::create($data);
        return $news;
    }

    /**
     * Fetch the latest news from the RSS feed and store it in the database.
     *
     * @return RedirectResponse
     */
    public function fetchNews (): RedirectResponse
    {
        try {
            // Fetch RSS feed data
            $response = Http::get('https://rss.punchng.com/v1/category/latest_new');
            if ($response->status() !== 200) {
                throw new RuntimeException('Failed to fetch RSS feed');
            }
            $xml = $response->body();
            $xmlObject = $this->parseXML($xml);      
            foreach ($xmlObject['channel']['item'] as $item) {
                $data = [];
                $data['title'] = (string) $item['title'];
                $data['link'] = (string) $item['link'];
                $data['description'] = gettype($item['description']) === 'string' ? $item['description'] : NULL;
                $data['image'] = isset($item['enclosure']['@attributes']['url']) ? (string) $item['enclosure']['@attributes']['url'] : NULL;
                $data['date_added'] = Carbon::parse($item['pubDate'])->format('Y-m-d H:i:s');
    
                // Check if the article with the same title exists in the database
                $existingArticle = News::where('title', $data['title'])->exists();
                if (! $existingArticle) {
                    $news = $this->store($data);
                    SendNotification::dispatch($news);
                }
            }        
        } catch (\Throwable $error) {
            report($error->getMessage());
        }
        notify()->success('Welcome to Laravel Notify ⚡️');
        return Redirect::route('home');
    }    


    public function parseXML (string $xml): array
    {
        $simpleXml = simplexml_load_string($xml);
        if ($simpleXml === false) {
            throw new InvalidArgumentException('Invalid XML string provided');
        }
        $xmlObject = simplexml_load_string($xml);
        $json = json_encode($xmlObject);
        $array = json_decode($json,TRUE);
        return $array;
    }

}
