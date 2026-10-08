<?php

namespace App\View\Components;

use App\Modules\User\Models\Customer;
use App\Modules\User\Models\CustomerPrefer;
use App\Modules\Navigation\Models\Navigation;
use App\Services\FrontMenuService;
use App\Services\FrontLocaleService;
use App\Services\ProductService;
use App\Services\SettingService;
use App\Services\SnsIconService;
use App\Modules\Product\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Layout extends Component
{


    private $settingService;
    private $productService;
    private $frontMenuService;
    private $frontLocaleService;
    private $snsIconService;
    /**
     * FrontLayout constructor.
     */
    public function __construct(SettingService $settingService,
                                ProductService $productService,
                                FrontMenuService $frontMenuService,
                                FrontLocaleService $frontLocaleService,
                                SnsIconService $snsIconService)
    {
        $this->settingService = $settingService;
        $this->productService = $productService;
        $this->frontMenuService = $frontMenuService;
        $this->frontLocaleService = $frontLocaleService;
        $this->snsIconService = $snsIconService;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $data = [];
        $data['setting'] = app('settings')['setting'];
        $data['header_logo_url'] = $this->resolveHeaderLogoUrl($data['setting']);
        $data['footer_logo_url'] = $this->resolveFooterLogoUrl($data['setting']);
        $data['hotTags'] = $this->productService->getHotTags(6);
        $data['nav'] = $this->frontMenuService->build();
        $data['footerNavGroups'] = $this->buildFooterNavGroups();
        $data['footerContact'] = $this->buildFooterContact($data['setting']);
        $data['contactPopup'] = $this->buildContactPopup($data['setting']);
        $data['locales'] = $this->frontLocaleService->build();
        $data['search'] = $this->buildSearchData($data['setting']);
        $data['snsIcons'] = $this->snsIconService->getLinkIcons();
        $data['snsShareIcons'] = $this->snsIconService->getShareIcons();
        $data['need_auth'] = $this->isNeedAuth();

        $request = request();
        $ip = $request->ip();
        $customer = null;
        if ($ip) {
            $customer = Customer::query()->where('ip', $ip)->orderByDesc('id')->first();
        }

        if ($data['need_auth']) {
            $allowRoutes = [
                'login',
                'login.submit',
                'register',
                'register.submit',
                'forget',
                'forget.submit',
                'logout',
            ];

            if (!Auth::guard('cust')->check() && !$request->routeIs($allowRoutes)) {
                return redirect()->route('login', [
                    'redirect' => $request->getRequestUri(),
                ]);
            }

            if (Auth::guard('cust')->check()) {
                $data['customer_id'] = Auth::guard('cust')->id();
            }
        } else {
            if (!$customer && $ip) {
                $username = 'guest_'.Str::lower(Str::random(8));
                $password = Str::random(12);

                $customer = Customer::create([
                    'username' => $username,
                    'email' => $username.'@example.com',
                    'password' => Hash::make($password),
                    'ip' => $ip,
                ]);
            }

            if ($customer) {
                $data['customer_id'] = $customer->id;
            }
        }

        $data['wishlist_products'] = [];
        $customerId = (int)($data['customer_id'] ?? 0);
        if ($customerId > 0) {
            $productIds = CustomerPrefer::query()
                ->where('customer_id', $customerId)
                ->orderByDesc('id')
                ->pluck('product_id')
                ->unique()
                ->values()
                ->all();

            if (!empty($productIds)) {
                $data['wishlist_products'] = Product::query()
                    ->with(['translations', 'productMainImage'])
                    ->active()
                    ->whereIn('id', $productIds)
                    ->orderByRaw('FIELD(id,' . implode(',', array_map('intval', $productIds)) . ')')
                    ->get()
                    ->values();
            }
        }

        return view('layouts.front.app', compact('data'));
    }

    private function resolveHeaderLogoUrl($setting): string
    {
        $inner = front_image_url($setting->inner_logo ?? '');
        if ($inner !== '') {
            return $inner;
        }

        $site = front_image_url($setting->logo ?? '');
        if ($site !== '') {
            return $site;
        }

        return '/front/imgs/logo2.svg';
    }

    private function resolveFooterLogoUrl($setting): string
    {
        $bottom = front_image_url($setting->bottom_logo ?? '');
        if ($bottom !== '') {
            return $bottom;
        }

        return '/front/imgs/footer_logo.png';
    }

    private function buildFooterContact($setting): array
    {
        $brief = trim((string)($setting->company_brief ?? ''));
        $address = trim((string)($setting->company_address ?? ''));

        $emailRaw = trim((string)($setting->contract_email ?? ''));
        $email = '';
        if ($emailRaw !== '') {
            $parts = array_values(array_filter(array_map('trim', explode(',', $emailRaw)), fn ($v) => $v !== ''));
            $email = $parts[0] ?? '';
        }

        $phoneRaw = trim((string)($setting->contract_mobile ?? ''));
        $phone = '';
        if ($phoneRaw !== '') {
            $parts = array_values(array_filter(array_map('trim', explode(',', $phoneRaw)), fn ($v) => $v !== ''));
            $phone = $parts[0] ?? '';
        }

        return [
            'brief' => $brief,
            'email' => [
                'label' => $email,
                'href' => $email !== '' ? ('mailto:' . $email) : '',
            ],
            'address' => $address,
            'phone' => [
                'label' => $phone,
                'href' => $phone !== '' ? ('tel:' . $phone) : '',
            ],
        ];
    }

    private function buildContactPopup($setting): array
    {
        $split = static function (?string $value): array {
            $value = trim((string)$value);
            if ($value === '') {
                return [];
            }
            return array_values(array_filter(array_map('trim', explode(',', $value)), fn ($v) => $v !== ''));
        };

        $phones = array_map(function ($phone) {
            return [
                'label' => $phone,
                'href' => 'tel:' . $phone,
                'target' => null,
            ];
        }, $split($setting->contract_mobile ?? ''));

        $whatsapps = array_map(function ($num) {
            $digits = preg_replace('/\D+/', '', (string)$num);
            $href = $digits !== ''
                ? ('https://wa.me/' . $digits . '?text=' . rawurlencode('Hello'))
                : '';
            return [
                'label' => $num,
                'href' => $href,
                'target' => '_blank',
            ];
        }, $split($setting->whatsapp ?? ''));
        $whatsapps = array_values(array_filter($whatsapps, fn ($item) => $item['href'] !== ''));

        $teamsLink = trim((string)($setting->teams_link ?? ''));
        $teamsLabel = trim((string)($setting->skype ?? ''));

        $emails = array_map(function ($email) {
            return [
                'label' => $email,
                'href' => 'mailto:' . $email,
                'target' => null,
            ];
        }, $split($setting->contract_email ?? ''));

        $qrWechat = front_image_url($setting->qr_code ?? '');
        $qrWhatsapp = front_image_url($setting->qr_code_whatsapp ?? '');
        $qrs = [];
        if ($qrWechat !== '') {
            $qrs[] = [
                'type' => 'wechat',
                'src' => $qrWechat,
            ];
        }
        if ($qrWhatsapp !== '') {
            $qrs[] = [
                'type' => 'whatsapp',
                'src' => $qrWhatsapp,
            ];
        }

        return [
            'phones' => $phones,
            'whatsapps' => $whatsapps,
            'teams' => (
                $teamsLink !== ''
                    ? [
                        'label' => $teamsLabel !== '' ? $teamsLabel : 'Instagram',
                        'href' => $teamsLink,
                        'target' => '_blank',
                    ]
                    : null
            ),
            'emails' => $emails,
            'qrs' => $qrs,
        ];
    }

    private function buildFooterNavGroups(): array
    {
        $groups = Navigation::query()
            ->with(['translations', 'children' => function ($q) {
                $q->where('is_show', 1)->orderByDesc('sort')->orderBy('id');
            }, 'children.translations'])
            ->area(Navigation::AREA_FOOT)
            ->where('parent_id', 0)
            ->where('is_show', 1)
            ->orderByDesc('sort')
            ->orderBy('id')
            ->limit(4)
            ->get();

        $result = [];
        foreach ($groups as $group) {
            $children = [];
            foreach ($group->children ?? [] as $child) {
                if ((int)($child->is_show ?? 1) !== 1) {
                    continue;
                }
                $children[] = [
                    'label' => $child->name,
                    'url' => $child->url ?: '#',
                    'target' => (int)($child->is_new ?? 0) === 1 ? '_blank' : null,
                    'rel' => ((int)($child->is_nofollow ?? 0) === 1)
                        ? (((int)($child->is_new ?? 0) === 1) ? 'noopener noreferrer nofollow' : 'nofollow')
                        : (((int)($child->is_new ?? 0) === 1) ? 'noopener noreferrer' : null),
                ];
            }

            $result[] = [
                'label' => $group->name,
                'url' => $group->url ?: '#',
                'target' => (int)($group->is_new ?? 0) === 1 ? '_blank' : null,
                'rel' => ((int)($group->is_nofollow ?? 0) === 1)
                    ? (((int)($group->is_new ?? 0) === 1) ? 'noopener noreferrer nofollow' : 'nofollow')
                    : (((int)($group->is_new ?? 0) === 1) ? 'noopener noreferrer' : null),
                'children' => $children,
            ];
        }

        return $result;
    }

    private function buildSearchData($setting): array
    {
        $placeholder = trim((string)($setting->search_placeholder ?? ''));
        $hotKeywords = trim((string)($setting->search_hot_keywords ?? ''));
        $hotItems = [];
        if ($hotKeywords !== '') {
            foreach (explode(',', $hotKeywords) as $keyword) {
                $keyword = trim($keyword);
                if ($keyword !== '') {
                    $hotItems[] = $keyword;
                }
            }
        }

        $query = trim((string)request()->get('q', ''));
        if ($query === '') {
            $query = trim((string)request()->get('keywords', ''));
        }

        return [
            'placeholder' => $placeholder ?: 'Search For...',
            'hot' => $hotItems,
            'q' => $query,
            'action' => route('search'),
        ];
    }

    private function isNeedAuth(): bool
    {
        $path = base_path('resources/needauth.txt');
        if (!is_file($path)) {
            return false;
        }

        $value = trim((string)file_get_contents($path));
        return $value === '1';
    }
}
