<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Profile;
// 以下を追記
use App\Prohistory;
// 以下を追記
use Carbon\Carbon;
class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        // Varidationをおこなう
        $this->validate($request, Profile::$rules);
        
        $profile = new Profile();
        $form = $request->all();
        
        unset($form['_token']);
        unset($form['image']);
        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }

    public function index(Request $request)
    {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
     }

  // 以下を追記

    public function edit(Request $request)
    {
      // News Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
    }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      // News Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      if ($request->remove == 'true') {
          $profile_form['image_path'] = null;
      } elseif ($request->file('image')) {
          $path = $request->file('image')->store('public/image');
          $profile_form['image_path'] = basename($path);
      } else {
          $profile_form['image_path'] = $profile->image_path;
      }

      unset($profile_form['_token']);
      unset($profile_form['image']);
      unset($profile_form['remove']);
      $profile->fill($profile_form)->save();
      
      // 以下を追記
      $prohistory = new Prohistory();
      $prohistory->profile_id = $profile->id;
      $prohistory->edited_at = Carbon::now();
      $prohistory->save();
      
      return redirect()->back();
  }
  public function delete(Request $request)
  {
      $profile = Profile::find($request->id);
      // 削除する
      $profile->delete();
      return redirect('admin/profile/');
  }  
}
