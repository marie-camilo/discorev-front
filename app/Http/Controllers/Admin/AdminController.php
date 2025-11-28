<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DiscorevApiService;
use App\Models\Api\JobOffer;
use App\Models\Api\User;
use App\Models\Api\Admin;
use App\Models\Api\History;
use App\Models\Api\Payment;
use App\Models\Api\Subscription;
use App\Models\Api\Tag;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $user = Session::get('user');
        $offersApi = $this->api->get('job_offers');
        $users = $this->api->get('users');
        $historyApi = $this->api->get('histories');
        $subscriptionsApi = $this->api->get('subscriptions');
        $paymentsApi = $this->api->get('payments');
        $tagsApi = $this->api->get('tags');
        $adminsApi = $this->api->get('admins');

        $offers = JobOffer::fromApiCollection($offersApi);
        $users = User::fromApiCollection($users);
        $history = History::fromApiCollection($historyApi);
        $subscriptions = Subscription::fromApiCollection($subscriptionsApi);
        $payments = Payment::fromApiCollection($paymentsApi);
        $tags = Tag::fromApiCollection($tagsApi);
        $admins = Admin::fromApiCollection($adminsApi);

        $paymentsInMonth = $payments->where('paidAt', today())->count();
        // etc.

        return view('admin.index ', compact('user', 'users', 'offers', 'history', 'payments', 'subscriptions', 'tags', 'admins'));
    }
}
