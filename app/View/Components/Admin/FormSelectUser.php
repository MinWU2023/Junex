<?php

namespace App\View\Components\Admin;

use App\Modules\Admin\Models\User;
use App\Modules\Product\Models\ProductBrand;
use Illuminate\View\Component;

class FormSelectUser extends Component
{

    public $verify;
    public $user_id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($verify, $user)
    {
        //
        $this->verify = $verify;
        if (!empty($user)) {
            $this->user_id = $user->id;
        } else {
            $this->user_id = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $users = User::query()->get();
        return view('components.admin.form-select-user', [
            'verify' => $this->verify,
            'user_id' => $this->user_id,
            'users' => $users->toArray()
        ]);
    }
}
