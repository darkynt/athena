<?php namespace Zeropingheroes\Lanager;

use Zeropingheroes\Lanager\UserAchievements\UserAchievementService,
	Zeropingheroes\Lanager\Users\UserService,
	Zeropingheroes\Lanager\Achievements\AchievementService,
	Zeropingheroes\Lanager\Lans\LanService;
use Zeropingheroes\Lanager\NotificationListener;
use View, Notification, Redirect;

class UserAchievementsController extends BaseController {

	protected $route = 'user-achievements';

	public function __construct()
	{
		parent::__construct();
		$this->service = new UserAchievementService($this);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$eagerLoad = ['user', 'lan', 'achievement'];
		$userAchievements = $this->service->all([], $eagerLoad);

		return View::make('user-achievements.index')
					->with('title','User Achievements')
					->with('userAchievements', $userAchievements);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$users 			= (new UserService((new NotificationListener)))->lists('username', 'id');
		$achievements 	= (new AchievementService((new NotificationListener)))->lists('name', 'id');
		$lans 			= (new LanService((new NotificationListener)))->lists('name', 'id');

		return View::make('user-achievements.create')
					->with('title','Award Achievement')
					->with('userAchievement',null)
					->with('users',$users)
					->with('achievements',$achievements)
					->with('lans',$lans);
	}

	/**
	 * Show the form for editing an existing resource.
	 *
	 * @return Response
	 */
	public function edit( $userAchievementId )
	{
		$userAchievement = $this->service->single($userAchievementId);

		$users 			= (new UserService((new NotificationListener)))->lists('username', 'id');
		$achievements 	= (new AchievementService((new NotificationListener)))->lists('name', 'id');
		$lans 			= (new LanService((new NotificationListener)))->lists('name', 'id');

		return View::make('user-achievements.edit')
					->with('title','Award Achievement')
					->with('userAchievement',$userAchievement)
					->with('users',$users)
					->with('achievements',$achievements)
					->with('lans',$lans);
	}

	public function storeSucceeded( BaseResourceService $service )
	{
		Notification::success( $service->messages() );
		return Redirect::route( $this->route . '.index' );
	}

	public function updateSucceeded( BaseResourceService $service )
	{
		Notification::success( $service->messages() );
		return Redirect::route( $this->route . '.index' );
	}
}