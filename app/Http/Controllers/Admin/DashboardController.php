<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Facades\Utils;
use App\Repositories\KvpRepository;
use App\Repositories\NewsRepository;
use App\Repositories\PirepRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use PragmaRX\Version\Package\Facade as Version;
use vierbergenlars\SemVer\version as semver;

class DashboardController extends Controller
{
    private $kvpRepo;
    private $newsRepo;
    private $pirepRepo;
    private $userRepo;

    /**
     * DashboardController constructor.
     *
     * @param KvpRepository $kvpRepo
     * @param NewsRepository $newsRepo
     * @param PirepRepository $pirepRepo
     * @param UserRepository $userRepo
     */
    public function __construct(
        KvpRepository $kvpRepo,
        NewsRepository $newsRepo,
        PirepRepository $pirepRepo,
        UserRepository $userRepo
    ) {
        $this->kvpRepo = $kvpRepo;
        $this->newsRepo = $newsRepo;
        $this->pirepRepo = $pirepRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Check if a new version is available by checking the VERSION file from
     * S3 and then using the semver library to do the comparison. Just show
     * a session flash file on this page that'll get cleared right away
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function checkNewVersion()
    {
        try {
            if ($this->kvpRepo->get('new_version_available', false) === true) {
                $latest_version = $this->kvpRepo->get('latest_version_tag');
                Flash::warning('New version '.$latest_version.' is available!');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Flash::warning('Could not contact phpVMS for version check');
        }
    }

    /**
     * Show the admin dashboard
     *
     * @param Request $request
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->checkNewVersion();

        return view('admin.dashboard.index', [
            'news'           => $this->newsRepo->getLatest(),
            'pending_pireps' => $this->pirepRepo->getPendingCount(),
            'pending_users'  => $this->userRepo->getPendingCount(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news(Request $request)
    {
        if ($request->isMethod('post')) {
            $attrs = $request->post();
            $attrs['user_id'] = Auth::user()->id;

            $this->newsRepo->create($attrs);
        } elseif ($request->isMethod('delete')) {
            $news_id = $request->input('news_id');
            $this->newsRepo->delete($news_id);
        }

        return view('admin.dashboard.news', [
            'news' => $this->newsRepo->getLatest(),
        ]);
    }
}
