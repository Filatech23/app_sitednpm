<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use App\Models\Userdirec;
use DB,Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'dnpmsiteg_users';
    
    protected $guarded=[];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo('App\Models\GiwuRole','id_role','id_role');
    }

	public static function getListeUsers(Request $req){

		$query = self::with(['role'])->orderBy('name','asc');

        $query->WhereHas('role', function ($q) { $q->where('id_role', '<>', '1');});

		$recherche = $req->get('query');
		if(isset($recherche)){
			$query->where(function ($query) use ($recherche){
				$query->orwhere('name','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('prenom','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('email','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('tel_user','like','%'.strtoupper(trim($recherche).'%'));
			});
		}
        
		return $query;
	}
	public static function sltListUser(){
		// $query = self::all()->pluck('name','id');
        $query =  self::select(DB::raw("CONCAT(name,' ',prenom) AS nomprenom"),'dnpmsiteg_users.id')
                            ->whereNotIn('dnpmsiteg_users.id',[1])
                            ->distinct()->get()->pluck('nomprenom','id');
		return $query;
	}
    
    public static function EtatUser($id){
        if($id == "1"){
            return "Activé";
        }else{
            return "Désactivé";
        }
    }

}
