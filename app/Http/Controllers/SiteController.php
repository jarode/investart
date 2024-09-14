<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\InvestmentCase;
use App\Models\Language;
use App\Models\Page;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function blog()
    {
        $pageTitle = "Blog";
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->first();
        $blogs = Frontend::where('data_keys', 'blog.element')->paginate(getPaginate());
        return view($this->activeTemplate . 'blog', compact('pageTitle', 'sections', 'blogs'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $user      = auth()->user();
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'user', 'sections'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        $notify[] = ['success', 'Language changed successfully!'];
        return back()->withNotify($notify);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:subscribers,email',
            ],
            [
                'email.unique' => 'You have already subscribed to us'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'code'    => 200,
                'status'  => 'error',
                'message' => $validator->errors()->all(),
            ]);
        }

        $subscribe        = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();

        $notify = 'Thank you for subscribing us';

        return response()->json([
            'code'    => 200,
            'status'  => 'success',
            'message' => $notify,
        ]);
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $blogElement                     = Frontend::where('id', '!=', $id)->where('data_keys', 'blog.element')->take(10)->get();

        $seoContents['title']              = $blog->data_values->title;
        $seoContents['social_title']       = $blog->data_values->title;
        $seoContents['description']        = strip_tags(@$blog->data_values->description_nic);
        $seoContents['social_description'] = strip_tags(strLimit(@$blog->data_values->description_nic, 150));
        $seoContents['image']              = getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '970x450');
        $seoContents['image_size']         = '970x450';
        $pageTitle                         = "Blog Details";

        return view($this->activeTemplate . 'blog_details', compact('blog', 'blogElement', 'pageTitle', 'seoContents'));
    }


    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);

        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

    public function caseDetails($code)
    {
        $investmentCase = InvestmentCase::where('case_code', $code)->approved()->with(['comments.user', 'reviews.user', 'plans', 'activePlan.schedule'])->firstOrFail();
        $pageTitle = "Investment Case Details";
        $latestCases = InvestmentCase::latest()
            ->active()
            ->where('user_id', '!=', 0)->with(['user', 'activePlan.schedule'])->where('id', '!=', $investmentCase->id)->take(5)->get();

        $seoContents['title']              = $investmentCase->title;
        $seoContents['description']        = strip_tags(@$investmentCase->overview);
        $seoContents['image']              = getImage(getFilePath('investmentImage') . '/' . $investmentCase->image, getFileSize('investmentImage'));
        $seoContents['image_size']         = getFileSize('investmentImage');
        return view($this->activeTemplate . 'case_details', compact('investmentCase', 'pageTitle', 'latestCases', 'seoContents'));
    }

    public function investor($username)
    {
        $investor  = User::active()->where('username', $username)->firstOrFail();
        $pageTitle = "User Profile";
        return view($this->activeTemplate . 'investor.about', compact('investor', 'pageTitle'));
    }
    public function cases($username)
    {
        $investor  = User::active()->where('username', $username)->firstOrFail();
        $pageTitle = "User Cases";
        $cases     = InvestmentCase::approved()->where('user_id', $investor->id)->with('user', 'reviews')->latest()->paginate(getPaginate(12));
        return view($this->activeTemplate . 'investor.cases', compact('investor', 'pageTitle', 'cases'));
    }
    public function comments($username)
    {
        $investor = User::active()->where('username', $username)->with('comments')->firstOrFail();
        $pageTitle = "User Comments";
        return view($this->activeTemplate . 'investor.comments', compact('investor', 'pageTitle'));
    }

    public function reviews($username)
    {
        $investor  = User::active()->where('username', $username)->with('reviews')->firstOrFail();
        $pageTitle = "User Reviews";
        return view($this->activeTemplate . 'investor.reviews', compact('investor', 'pageTitle'));
    }

    public function investment()
    {
        $pageTitle = "Investments";
        $cases     = InvestmentCase::latest('id')->approved()->active()->with('user', 'reviews', 'plans')->paginate(getPaginate(18));
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'investment')->first();
        return view($this->activeTemplate . 'investment', compact('pageTitle', 'cases', 'sections'));
    }
}
