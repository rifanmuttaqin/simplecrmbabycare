<?php

namespace App\Observers;

use App\Model\Customer\Customer;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CustomerObserver
{
    /**
     * Handle the Customer "saving" event.
     *
     * @param  \App\Model\Customer\Customer  $customer
     * @return void
     */
    public function saving(Customer $customer)
    {
        $customer->tgl_lahir = Carbon::parse(request()->param['tgl_lahir']);
    }

}
