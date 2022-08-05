<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
        protected $guarded = ['id'];
         protected $fillable = ['user_id', 'user_agent', 'ip_address','created_at'];   
        protected $table = 'login_activities';
        public $timestamps = false;
        
        public function user(){
            
           return $this->belongsTo(User::class);
        }
}
