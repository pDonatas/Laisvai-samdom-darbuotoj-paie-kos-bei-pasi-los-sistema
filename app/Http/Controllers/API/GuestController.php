<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Services\MailingService;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestController extends BaseController
{
    protected MailingService $mailingService;

    public function __construct(MailingService $mailingService)
    {
        $this->mailingService = $mailingService;
    }

    public function home(): JsonResponse
    {
        $posts = Post::all();
        $categories = Category::all();

        if (!Session::has('user_locale')) {
            Session::put('user_locale', 'lt');
        }

        return $this->return(compact('posts', 'categories'));
    }

    public function index(): JsonResponse
    {
        return $this->return();
    }

    public function contactForm(Request $request): JsonResponse
    {
        $this->mailingService->sendMail($request->toArray());

        return $this->return(['success' => 'Message sent successfully']);

    }
    public function privacyPolicy(): JsonResponse
    {
        return $this->return(['privacy policy data']);
    }
}
