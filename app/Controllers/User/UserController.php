<?php
namespace App\Controllers\User;

use App\Models\User\User;
use App\Models\User\Role;
use App\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Respect\Validation\Validator as v;

class UserController extends Controller 
{

    /**
     * Retrive all users
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function index($request,$response,$args)
    {
        $users = Role::rightJoin('users','roles.id','=','users.role_id')
                        ->where('users.deleted','=','0')
                        ->paginate(10,['*'],'page',$request->getParam('page'));
     
        return $this->view->render($response,'auth/users.twig',[
            'items' => $users,
        ]);
    }

    /**
     * Search a user
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request,$response,$args)
    {
       
        $name =  ltrim($request->getParam('name'));
        $email = ltrim($request->getParam('email'));
        $role =  $request->getParam('role');
    
      
        $search = Role::rightJoin('users','roles.id','=','users.role_id')
                        ->where('users.name','like',"%$name%")
                        ->where('users.email','like',"%$email%")
                        ->where('roles.id','like',"%$role%")
                        ->where('users.deleted','=','0')
                        ->limit(12)->get();

        return $this->view->render($response,'auth/search.twig',[
            'items' => $search
        ]);
    }
    /**
     * Return edit view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function edit($request,$response,$args)
    {
        $user = User::find($args['id']);

        return $this->view->render($response,'auth/edit.twig',[
            'user' => $user
        ]);

    }

    /**
     * Update a specific user
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function update($request,$response,$args)
    {
         
        
        /**
         * Handling validation
         */
        $Validator = $this->Validator->validate($request,[
            'name' => v::notEmpty(),
            'email' => v::email(),
            'phone' => v::phone(),
            'role'  => v::notEmpty()
        ]);

        // is validation failed
        if($Validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('user.edit',[
                'id' => $args['id']
            ]));
        }

        $user = User::find($args['id']);

        $user->update([
            'name' => $request->getParam('name'),
            'email' => $request->getParam('email'),
            'phone' => $request->getParam('phone'),
            'role_id' => $request->getParam('role'),
        ]);

        $this->flash->addMessage('success','You have successfully updated '.ucwords($user->name).' information');

        return $response->withRedirect($this->router->pathFor('user.index'));

    }

    /**
     * Trash user
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function trashUser($request,$response,$args)
    {
        $user = User::find($args['id']);

        $user->update([
            'deleted_by' => $this->auth->user()->name,
            'deleted'    => '1',
            'deleted_at' => date('Y-m-d H:i:s')
        ]);

        $this->flash->addMessage('danger','You have deleted '.ucwords($user->name));

        return $response->withRedirect($this->router->pathFor('user.index'));
    }
}