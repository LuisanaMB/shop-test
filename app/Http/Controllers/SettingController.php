<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Order;
use Artisan;
use DB;

class SettingController extends Controller
{
    public function install(){
        if (!Schema::hasTable('users')){
            Artisan::call('migrate');
            Artisan::call('db:seed');

            $oldOrders = DB::table('orders')
                            ->orderBy('id', 'ASC')
                            ->get();
            
            $oldUsers = $oldOrders->groupBy('customer_email');
            
            foreach ($oldUsers as $oldUser){
                $user = new User();
                $user->name = $oldUser[0]->customer_name;
                $user->email = $oldUser[0]->customer_email;
                $user->phone = $oldUser[0]->customer_mobile;
                $user->save();
            }

            foreach ($oldOrders as $oldOrder){
                $userOrder = User::where('email', '=', $oldOrder->customer_email)
                                ->select('id')
                                ->first();

                $order = new Order();
                $order->user_id = $userOrder->id;
                $order->status = $oldOrder->status;
                $order->created_at = $oldOrder->created_at;
                $order->updated_at = $oldOrder->updated_at;
                $order->save();
            }
        }
        
        return redirect('/');
    }
}